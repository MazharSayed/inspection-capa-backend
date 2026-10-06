# Inspection CAPA Backend

Laravel API for inspection configuration, CAPA requests and inspection approvals.

Frontend (Vue 3): https://github.com/MazharSayed/inspection-capa-frontend

## Requirements

PHP 8.2+, Composer, MySQL

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create a MySQL database named `inspection_capa` and set the `DB_*` values in `.env`, then:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

The API runs at http://127.0.0.1:8000/api.

## Endpoints

| Method | URL | Description |
|---|---|---|
| GET | `/api/filters` | Dropdown options for all filters, including the relations used for cascading |
| GET | `/api/inspection-configs` | Sub-activity configuration list |
| GET | `/api/inspection-configs/{id}` | One configuration |
| PUT | `/api/inspection-configs/{id}` | Update levels and random inspection count |
| GET | `/api/capa-requests` | CAPA requests list |
| GET | `/api/inspection-requests` | Inspection requests list |
| GET | `/api/inspection-requests/{id}` | Request details, documents and approval steps |

List endpoints accept these query filters:

- `inspection-configs`: `project_id`, `division_id`, `sub_division_id`, `activity_id`, `q`
- `capa-requests`: `project_id`, `division_id`, `sub_division_id`, `activity_id`, `sub_activity_id`, `created_at` (YYYY-MM-DD), `status`, `q`
- `inspection-requests`: `project_id`, `division_id`, `sub_division_id`, `activity_id`, `status`, `q`

`PUT /api/inspection-configs/{id}` accepts `level_engineer`, `level_qcs`, `level_qaqc` (booleans) and `random_inspection_count` (integer, 0 or more, or null).

A Postman collection is in `docs/postman_collection.json`. Set its `base_url` variable to `http://127.0.0.1:8000/api`.

## Structure

- Migrations: one per table (projects, divisions, sub_divisions, activities, sub_activities, inspection_requests, approvals, documents, capa_requests)
- Filtering lives in model scopes, response shaping in API Resources, validation in a Form Request
- `DatabaseSeeder` loads the sample data used in the screens

Hierarchy: Project, Division, Sub-Division, Activity, Sub-Activity. A project is linked to the rest of the hierarchy through its sub-activities, which is what the frontend uses to cascade the filters.

## Notes

- Built with the help of AI tools (Claude and GitHub Copilot). I reviewed and tested the code myself.
- The Division, Sub-Division and Activity names in the seeder are sample data, because the designs don't show that hierarchy.
- Sobha Seahaven has the 10 sub-activities from the design. The other projects have only the ones their CAPA rows use, so the Configuration list shows 13 rows with no project selected.
- Inspection request 1 is the one shown in the detail design. Each CAPA row has its own inspection request.
