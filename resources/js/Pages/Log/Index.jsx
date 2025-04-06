import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import { FaDownload } from "react-icons/fa";
import Pagination from "@/components/Pagination";

export default function Index({ 
    auth, 
    logs, 
    projects, 
    severities, 
    users, 
    filters,
    isAdmin 
}) {
    const { data, setData, get, processing } = useForm({
        search: filters.search || "",
        project_id: filters.project_id || "",
        severity: filters.severity || "",
        user_id: filters.user_id || "",
        sort_by: filters.sort_by || "created_at",
        sort_order: filters.sort_order || "desc",
    });

    const handleFilterSubmit = (e) => {
        e.preventDefault();
        get(route("logs.index"), { 
            preserveState: true, 
            replace: true 
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Log Entries
                    </h2>
                    <a
                        href={route("logs.export", data)}
                        method="get"
                        as="button"
                        className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center"
                    >
                        <FaDownload className="mr-2" /> Export to Excel
                    </a>
                </div>
            }
        >
            <Head title="Log Entries" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100 p-4">
                    <form 
                        onSubmit={handleFilterSubmit} 
                        className="mb-4 flex flex-wrap gap-4"
                    >
                        {/* User filter (samo za admine) */}
                        {isAdmin && (
                            <select
                                name="user_id"
                                value={data.user_id}
                                onChange={(e) => setData("user_id", e.target.value)}
                                className="border p-2 rounded w-full md:w-1/4"
                            >
                                <option value="">All Users</option>
                                {users.map((user) => (
                                    <option key={user.id} value={user.id}>
                                        {user.name}
                                    </option>
                                ))}
                            </select>
                        )}

                        {/* Search input */}
                        <input
                            type="text"
                            name="search"
                            value={data.search}
                            onChange={(e) => setData("search", e.target.value)}
                            placeholder="Search logs..."
                            className="border p-2 rounded w-full md:w-1/3"
                        />

                        {/* Project filter */}
                        <select
                            name="project_id"
                            value={data.project_id}
                            onChange={(e) => setData("project_id", e.target.value)}
                            className="border p-2 rounded w-full md:w-1/4"
                        >
                            <option value="">All projects</option>
                            {projects.map((project) => (
                                <option key={project.id} value={project.id}>
                                    {project.name}
                                </option>
                            ))}
                        </select>

                        {/* Severity level filter */}
                        <select
                            name="severity"
                            value={data.severity}
                            onChange={(e) => setData("severity", e.target.value)}
                            className="border p-2 rounded w-full md:w-1/4"
                        >
                            <option value="">All levels</option>
                            {Object.entries(severities).map(([value, label]) => (
                                <option key={value} value={value}>
                                    {label}
                                </option>
                            ))}
                        </select>

                        {/* Sort by */}
                        <select
                            name="sort_by"
                            value={data.sort_by}
                            onChange={(e) => setData("sort_by", e.target.value)}
                            className="border p-2 rounded w-full md:w-1/4"
                        >
                            <option value="created_at">Date</option>
                            <option value="severity_level">Severity level</option>
                        </select>

                        {/* Sort order */}
                        <select
                            name="sort_order"
                            value={data.sort_order}
                            onChange={(e) => setData("sort_order", e.target.value)}
                            className="border p-2 rounded w-full md:w-1/4"
                        >
                            <option value="desc">Descending</option>
                            <option value="asc">Ascending</option>
                        </select>

                        {/* Submit button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Filter
                        </button>
                    </form>

                    {/* Logs table */}
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white border border-gray-200 shadow-md">
                            <thead className="bg-gray-100">
                                <tr>
                                    <th className="py-2 px-4 border-b">Time</th>
                                    <th className="py-2 px-4 border-b">Level</th>
                                    <th className="py-2 px-4 border-b">Created By</th>
                                    <th className="py-2 px-4 border-b">Project</th>
                                    <th className="py-2 px-4 border-b">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                {logs.data.map((log) => (
                                    <tr 
                                        key={log.id} 
                                        className="hover:bg-gray-50"
                                    >
                                        <td className="py-2 px-4 border-b">
                                            {log.created_at}
                                        </td>
                                        <td className="py-2 px-4 border-b">
                                            {severities[log.severity_level]}
                                        </td>
                                        <td className="py-2 px-4 border-b">
                                            {log.user?.name || 'N/A'}
                                        </td>
                                        <td className="py-2 px-4 border-b">
                                            {log.project?.name || 'N/A'}
                                        </td>
                                        <td className="py-2 px-4 border-b">
                                            {log.message}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination */}
                    <div className="mt-4 flex justify-center">
                        <Pagination data={logs} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}