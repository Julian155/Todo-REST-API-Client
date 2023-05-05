<?php
declare(strict_types=1);

namespace App\Transfer\Business\DirectoryFileCleaner;

use App\Shared\Transfer\TransferConstants;
use App\Transfer\TransferConfig;

class DirectoryFileCleaner implements DirectoryFileCleanerInterface
{
    /**
     * @var \App\Transfer\TransferConfig
     */
    private TransferConfig $config;

    /**
     * @param \App\Transfer\TransferConfig $config
     */
    public function __construct(TransferConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function cleanGeneratedDirectory(): void
    {
        $files = glob(sprintf(
            '%s/%s/*',
            $this->config->getApplicationRootDirectory(),
            TransferConstants::GENERATED_PATH,
        ));

        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }
}
