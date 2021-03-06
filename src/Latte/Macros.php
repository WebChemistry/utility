<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Latte;

use Latte\CompileException;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;
use WebChemistry\Utility\Arrays;

final class Macros extends MacroSet
{

	/** @var mixed[] */
	private array $options = [
		'confirmMessage' => 'Do you really to continue?',
	];

	public static function install(Compiler $compiler, array $options = []): void
	{
		$me = new static($compiler);
		$me->options = Arrays::defaults($me->options, $options);

		$me->addMacro('confirm', null, null, [$me, 'macroConfirm']);
		$me->addMacro('phref', null, null, [$me, 'macroLink']);
	}

	public function macroConfirm(MacroNode $node, PhpWriter $writer): string
	{
		$words = $node->tokenizer->fetchWords();
		if (count($words) > 1) {
			throw new CompileException('Attribute n:confirm accepts at most 1 parameter');
		}

		$word = $words[0] ?? $this->options['confirmMessage'];

		$var = strpos($word, '$') !== false ? "' . %escape(%raw) . '" : "' . %escape(%word) . '";

		return $writer->write(
			'echo \'data-confirm="' . $var . '" onclick="return confirm(\\\'' . $var . '\\\')"\'',
			$word,
			$word
		);
	}

	public function macroLink(MacroNode $node, PhpWriter $writer): string
	{
		$node->modifiers = preg_replace('#\|safeurl\s*(?=\||\z)#i', '', $node->modifiers);

		$link = $writer->using($node)
			->write(
				'echo %escape(%modify(' .
				'$this->global->uiPresenter->link(%node.word, %node.array?)' .
				'))'
			);

		return sprintf('?> href="<?php %s ?>"<?php', $link);
	}

}
