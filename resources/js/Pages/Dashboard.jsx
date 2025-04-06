import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ isAdmin }) {

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {/* Projects */}
                        <Link href={route('projects.index')} className="block">
                            <div className="p-6 bg-white shadow rounded-lg text-center hover:shadow-lg transition">
                                <h3 className="text-lg font-semibold text-gray-700">Projects</h3>
                                <p className="text-gray-500">View and manage projects</p>
                            </div>
                        </Link>

                        {/* Logs */}
                        <Link href={route('logs.index')} className="block">
                            <div className="p-6 bg-white shadow rounded-lg text-center hover:shadow-lg transition">
                                <h3 className="text-lg font-semibold text-gray-700">Logs</h3>
                                <p className="text-gray-500">Review project log records</p>
                            </div>
                        </Link>

                        {/* Log Statistics */}
                        <Link href={route('logs.stats')} className="block">
                            <div className="p-6 bg-white shadow rounded-lg text-center hover:shadow-lg transition">
                                <h3 className="text-lg font-semibold text-gray-700">Log Statistics</h3>
                                <p className="text-gray-500">View log statistics</p>
                            </div>
                        </Link>

                        {/* Users (admin only) */}
                        {isAdmin && (
                            <Link href={route('users.index')} className="block">
                                <div className="p-6 bg-white shadow rounded-lg text-center hover:shadow-lg transition">
                                    <h3 className="text-lg font-semibold text-gray-700">Users</h3>
                                    <p className="text-gray-500">User management (admin)</p>
                                </div>
                            </Link>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}