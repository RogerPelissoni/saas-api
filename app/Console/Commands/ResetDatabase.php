<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{
  protected $signature = 'db:reset';
  protected $description = '🔄 Reinicia o sistema: limpa banco, caches, storage link e roda migrations com seeders';

  public function handle()
  {
    $this->info('🧹 Limpando caches...');
    $this->callSilent('cache:clear');
    $this->callSilent('config:clear');
    $this->callSilent('route:clear');
    $this->callSilent('view:clear');

    $this->info('🔗 Recriando storage link...');
    $this->callSilent('storage:link');

    $this->info('💥 Resetando banco de dados...');
    $this->call('migrate:fresh');

    $this->info('🌱 Rodando os seeders...');
    $this->call('db:seed');

    $this->info('✅ Ambiente pronto para uso!');
  }
}