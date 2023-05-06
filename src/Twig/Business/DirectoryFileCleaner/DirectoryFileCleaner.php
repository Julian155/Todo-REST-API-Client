<?php
declare(strict_types=1);

namespace App\Twig\Business\DirectoryFileCleaner;

use App\Shared\Kernel\KernelConstants;
use App\Twig\TwigConfig;

class DirectoryFileCleaner implements DirectoryFileCleanerInterface
{
    /**
     * @var \App\Twig\TwigConfig
     */
    private TwigConfig $config;

    /**
     * @param \App\Twig\TwigConfig $config
     */
    public function __construct(TwigConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $folderName
     *
     * @return void
     */
    public function cleanGeneratedDirectory(string $folderName): void
    {
        $files = glob(sprintf(
            '%s/%s/%s/*',
            $this->config->getApplicationRootDirectory(),
            KernelConstants::GENERATED_PATH,
            $folderName
        ));

        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }
}
