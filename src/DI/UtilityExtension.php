<?php declare(strict_types = 1);

namespace WebChemistry\Utility\DI;

use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\Utility\Latte\Macros;

final class UtilityExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'latte' => Expect::structure([
				'enable' => Expect::bool(interface_exists(ILatteFactory::class)),
				'macros' => Expect::structure([
					'confirmMessage' => Expect::string('Do you really want to continue?'),
				])
			])
		]);
	}

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		if ($config->latte->enable) {
			$service = CompilerExtensionUtility::getFactoryDefinitionByType($builder, ILatteFactory::class);

			$service->getResultDefinition()
				->addSetup('?->onCompile[] = function ($engine) { ?::install($engine->getCompiler(), ?); }', [
					'@self',
					Macros::class,
					(array) $config->latte->macros,
				]);
		}
	}

}
