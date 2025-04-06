import React from 'react';
import { useForm, Link } from '@inertiajs/react';

export default function Form({ className, user = null, isCreating, roles }) {
    const { data, setData, post, put, processing, errors } = useForm({
        name: user?.name || '',
        email: user?.email || '',
        password: '',
        role: user?.role || 'editor',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        isCreating
            ? post(route('users.store'))
            : put(route('users.update', user.id));
    };

    return (
        <div className={className}>
            <form onSubmit={handleSubmit} className="bg-white p-6 rounded shadow-md">
                <div className="mb-4">
                    <label htmlFor="name" className="block text-gray-700 mb-2">Name</label>
                    <input
                        id="name"
                        type="text"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        className="w-full border border-gray-300 rounded p-2"
                    />
                    {errors.name && <div className="text-red-600 text-sm mt-1">{errors.name}</div>}
                </div>

                <div className="mb-4">
                    <label htmlFor="email" className="block text-gray-700 mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        className="w-full border border-gray-300 rounded p-2"
                    />
                    {errors.email && <div className="text-red-600 text-sm mt-1">{errors.email}</div>}
                </div>

                <div className="mb-4">
                    <label htmlFor="password" className="block text-gray-700 mb-2">
                        Password {!isCreating && '(leave empty to keep unchanged)'}
                    </label>
                    <input
                        id="password"
                        type="password"
                        value={data.password}
                        onChange={(e) => setData('password', e.target.value)}
                        className="w-full border border-gray-300 rounded p-2"
                    />
                    {errors.password && <div className="text-red-600 text-sm mt-1">{errors.password}</div>}
                </div>

                <div className="mb-4">
                    <label htmlFor="role" className="block text-gray-700 mb-2">Role</label>
                    <select
                        id="role"
                        value={data.role}
                        onChange={(e) => setData('role', e.target.value)}
                        className="w-full border border-gray-300 rounded p-2"
                    >
                        {roles.map((role) => (
                            <option key={role.value} value={role.value}>
                                {role.label}
                            </option>
                        ))}
                    </select>
                    {errors.role && <div className="text-red-600 text-sm mt-1">{errors.role}</div>}
                </div>

                <div className="flex items-center justify-end">
                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        {isCreating ? 'Create User' : 'Update User'}
                    </button>
                    <Link
                        href={route('users.index')}
                        className="ml-4 text-gray-600 hover:underline"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    );
}