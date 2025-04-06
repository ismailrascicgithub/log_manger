import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Form from './Partials/Form';
import { Head } from '@inertiajs/react';

export default function Edit({ auth, project, isAdmin, users }) {
  return (
    <AuthenticatedLayout user={auth.user}>
      <Head title="Edit Project" />
      <div className="py-12">
        <Form
          className="max-w-4xl w-full mx-auto"
          project={project}
          isCreating={false}
          isAdmin={isAdmin}
          users={users}
        />
      </div>
    </AuthenticatedLayout>
  );
}
