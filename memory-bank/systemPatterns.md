# System Patterns

## System Architecture

- Monolithic Laravel application serving a Vue.js frontend via Inertia.js.
- Follows MVC pattern on the backend (Laravel).
- Component-based architecture on the frontend (Vue.js).

## Key Technical Decisions

- Use of Inertia.js to build a single-page application (SPA) experience with server-side routing and controllers.
- Adoption of Tailwind CSS for utility-first styling.
- Utilization of Font Awesome 6 (via CDN) for iconography, requiring `fas fa-*` (or `far`, `fab`) class syntax.

## Design Patterns in Use

- MVC (Model-View-Controller) - Laravel backend.
- Composition API and `<script setup>` in Vue.js components.
- Responsive design principles using flexbox, grid, and media queries.

## Component Relationships

- Laravel controllers render Vue components as pages.
- Vue components manage their own state and can interact via props and events, or through Inertia's global event bus or page props if necessary.
- Shared layouts (e.g., for authenticated sections with sidebars) are common. 