import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Form from './Partials/Form';
import { Head } from '@inertiajs/react';

export default function Create({ auth, isAdmin,users }) {
  return (
    <AuthenticatedLayout user={auth.user}>
      <Head title="Create Project" />
      <div className="py-12">
        <Form className="max-w-4xl w-full mx-auto" isCreating={true} isAdmin={isAdmin} users={users}
        />
      </div>
    </AuthenticatedLayout>
  );
}
