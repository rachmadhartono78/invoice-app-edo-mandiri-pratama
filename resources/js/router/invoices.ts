export default [
  {
    path: '/invoices',
    name: 'invoices.index',
    component: () => import('@/components/pages/invoices/Index.vue'),
    meta: { title: 'Invoice Management' }
  },
  {
    path: '/invoices/create',
    name: 'invoices.create',
    component: () => import('@/components/pages/invoices/Create.vue'),
    meta: { title: 'Create Invoice' }
  },
  {
    path: '/invoices/:id',
    name: 'invoices.view',
    component: () => import('@/components/pages/invoices/View.vue'),
    meta: { title: 'View Invoice' }
  },
  {
    path: '/invoices/:id/edit',
    name: 'invoices.edit',
    component: () => import('@/components/pages/invoices/Create.vue'),
    meta: { title: 'Edit Invoice' }
  },
];
