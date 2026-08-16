# Documentação do saas-api

Índice da documentação técnica do projeto. Este diretório existe para registrar
decisões e fluxos que não ficam óbvios só lendo o código.

- [Filas, Eventos e Mensageria](./filas-eventos-e-mensageria.md) — como uma
  baixa de título dispara, de forma assíncrona, uma notificação por e-mail
  (Redis) e uma mensagem no RabbitMQ consumida por um microsserviço
  separado em Node.js (`saas-invoice-service`). Cobre o padrão Event/
  Listener, o bug de `afterCommit` que corrigimos, vocabulário de
  mensageria, e troubleshooting.
