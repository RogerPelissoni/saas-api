<?php

namespace App\Services\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Ponto único de conexão com o RabbitMQ. Centralizar isso aqui evita
 * duplicar credenciais/timeouts em cada Command/Listener que precisa falar
 * com o broker, e é o único lugar que lê `config('services.rabbitmq.*')`.
 *
 * Nunca chame env() fora de arquivos de config — com `config:cache` ativo
 * em produção, chamadas a env() fora de config/*.php voltam null, porque o
 * cache guarda só o array já resolvido do config().
 */
class RabbitMqConnectionFactory
{
  public static function connection(): AMQPStreamConnection
  {
    return new AMQPStreamConnection(
      host: config('services.rabbitmq.host'),
      port: config('services.rabbitmq.port'),
      user: config('services.rabbitmq.user'),
      password: config('services.rabbitmq.password'),
      read_write_timeout: config('services.rabbitmq.read_write_timeout'),
    );
  }
}
