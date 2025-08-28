# Filament Multi-Tenant (Single Database)

🚀 Scaffolding para aplicações **multi-tenant em Laravel** usando **FilamentPHP** e estratégia **single database**.

## 📌 Arquitetura
- **Single Database**: todos os tenants compartilham a mesma base.
- **Isolamento lógico**: registros vinculados a `tenant_id`.
- **FilamentPHP**: painel administrativo moderno e flexível.
- **Laravel**: estrutura robusta para escalar módulos rapidamente.

## ⚙️ Instalação
```bash
git clone https://github.com/seu-usuario/filament-multi-tenant-single-db.git
cd filament-multi-tenant-single-db
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
