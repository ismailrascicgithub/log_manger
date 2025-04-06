import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Form from './Partials/Form';
import { Head } from '@inertiajs/react';

export default function Update({ auth, user, roles }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Edit User" />
            <div className="py-12">
                <Form 
                    className="max-w-4xl w-full mx-auto" 
                    user={user}
                    isCreating={false}
                    roles={roles}
                />
            </div>
        </AuthenticatedLayout>
    );
}