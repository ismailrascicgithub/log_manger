import React from 'react';
import { Head } from '@inertiajs/react';

const Stats = ({ stats }) => {
    return (
        <div className="py-8">
            <Head title="Log Statistics" />

            {/* Main statistic cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h3 className="text-xl font-semibold mb-2">Last 24 Hours</h3>
                    <p className="text-4xl font-bold text-blue-600">{stats.last24h}</p>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h3 className="text-xl font-semibold mb-2">Last Hour</h3>
                    <p className="text-4xl font-bold text-green-600">{stats.lastHour}</p>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h3 className="text-xl font-semibold mb-2">Total Logs</h3>
                    <p className="text-4xl font-bold text-purple-600">{stats.total}</p>
                </div>
            </div>

            {/* Severity type distribution */}
            <div className="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <h2 className="text-2xl font-semibold p-6 bg-gray-50">Distribution by Severity Types</h2>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 p-6">
                    {Object.entries(stats.severities).map(([severity, count]) => (
                        <div key={severity} className="bg-gray-50 p-4 rounded-lg">
                            <h3 className="text-lg font-medium text-gray-700">{severity}</h3>
                            <p className="text-3xl font-bold text-indigo-600">{count}</p>
                        </div>
                    ))}
                </div>
            </div>

            {/* Project statistics details */}
            <div className="bg-white rounded-lg shadow-md overflow-hidden">
                <h2 className="text-2xl font-semibold p-6 bg-gray-50">Project Statistics</h2>

                <div className="overflow-x-auto">
                    <table className="min-w-full">
                        <thead className="bg-gray-100">
                            <tr>
                                <th className="px-6 py-4 text-left text-sm font-semibold text-gray-700">Project</th>
                                <th className="px-6 py-4 text-center text-sm font-semibold text-gray-700">Total Logs</th>
                                <th className="px-6 py-4 text-center text-sm font-semibold text-gray-700">Latest Log</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-200">
                            {stats.projects.map((project) => (
                                <tr key={project.project}>
                                    <td className="px-6 py-4 whitespace-nowrap font-medium">{project.project}</td>
                                    <td className="px-6 py-4 text-center">
                                        <span className="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                            {project.count}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center text-sm text-gray-500">
                                        {project.latest_log || 'No logs'}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};

export default Stats;