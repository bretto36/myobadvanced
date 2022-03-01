<?php

namespace MyobAdvanced\Console;

use Illuminate\Console\GeneratorCommand;
use MyobAdvanced\AnonymousEntity;
use MyobAdvanced\CookieJar\CommandCookieJar;
use MyobAdvanced\MyobAdvanced;
use Symfony\Component\Console\Input\InputOption;

class MakeClass extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myob-advanced:make {--force=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an MYOB Advanced Class File';

    protected $type = 'MYOB Advanced Class';

    protected $entity;
    /**
     * @var mixed
     */
    private $host;
    /**
     * @var mixed
     */
    private $username;
    private $password;
    private $company;
    private $endpoint;
    private $endpointVersion;


    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->entity);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/myob-advanced-class.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $this->info('The following questions relate to the Class you wish to generate');

        $this->host            = $this->ask('Host', 'https://example.myobadvanced.com');
        $this->username        = $this->ask('Username', '');
        $this->password        = $this->secret('Password', '');
        $this->company         = $this->secret('Company', '');
        $this->endpoint        = $this->ask('Endpoint', 'Default');
        $this->endpointVersion = $this->ask('Endpoint Version', '20.200.001');
        $this->entity          = $this->ask('Entity', 'Customer');

        if (parent::handle() === false && (!$this->hasOption('force') || !$this->option('force'))) {
            return false;
        }

        return self::SUCCESS;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\MyobAdvanced\\' . $this->entity;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
        ];
    }


    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $myobAdvanced = new MyobAdvanced($this->host, $this->username, $this->password, $this->company, '', new CommandCookieJar());

        $object = (new AnonymousEntity())
            ->setEndpoint($this->endpoint)
            ->setEndpointVersion($this->endpointVersion)
            ->setEntity($this->entity);

        $response = $myobAdvanced->adhocSchema($object)->send();

        $ignoredKeys = ['id', 'rowNumber', 'note', 'custom'];

        foreach ($response->getObject() as $key => $value) {
            if (in_array($key, $ignoredKeys)) {
                continue;
            }

            if (is_array($value)) {
                // do something different
                // Add to list of linked entities

                continue;
            }

            if (count((array)$value) == 0) {
                // Standard Field
                dump($key, $value);
            }
        }

        $class = str_replace('{{ $endpoint }}', $this->endpoint, $class);
        $class = str_replace('{{ $endpointVersion }}', $this->endpointVersion, $class);

        return $class;
    }
}