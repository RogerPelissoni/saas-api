<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
  protected $signature = 'db:reset';
  protected $description = 'Limpa o banco e roda todas as migrations com seeders';

  public function handle()
  {
    $this->info('💥 Limpando o banco de dados...');
    $this->call('migrate:fresh');

    $this->info('🌱 Rodando os seeders...');
    $this->call('db:seed');

    $this->info('✅ Banco de dados pronto!');
  }
}
