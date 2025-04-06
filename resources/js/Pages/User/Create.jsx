import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Form from './Partials/Form';
import { Head } from '@inertiajs/react';

export default function Create({ auth, roles }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Create User" />
            <div className="py-12">
                <Form 
                    className="max-w-4xl w-full mx-auto" 
                    isCreating={true}
                    roles={roles}
                />
            </div>
        </AuthenticatedLayout>
    );
}