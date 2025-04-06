import React, { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link, useForm, Head } from "@inertiajs/react";
import { FaEdit, FaTrash, FaPlus } from "react-icons/fa";
import Pagination from "@/components/Pagination";
import useFlashMessages from "@/components/useFlashMessages";
import DeleteModal from "@/components/DeleteModal";

export default function Index({ auth, users }) {
    const { delete: destroy } = useForm();
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedUserId, setSelectedUserId] = useState(null);
    const statusMessage = useFlashMessages();

    const handleDelete = (id) => {
        setSelectedUserId(id);
        setIsModalOpen(true);
    };

    const confirmDelete = () => {
        destroy(route("users.destroy", selectedUserId), {
            onSuccess: () => {
                setIsModalOpen(false);
            },
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        User List
                    </h2>
                </div>
            }
        >
            <Head title="Users" />

            <div className="overflow-x-auto p-4 lg:w-12/12 lg:mx-auto bg-gray-100">
                {statusMessage.message && (
                    <div
                        className={`mb-4 p-4 rounded ${statusMessage.type === "success"
                                ? "bg-green-100 text-green-700"
                                : "bg-red-100 text-red-700"
                            }`}
                    >
                        {statusMessage.message}
                    </div>
                )}

                <table className="min-w-full bg-white border border-gray-200 shadow-md">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="py-2 px-4 border-b text-left">Id</th>
                            <th className="py-2 px-4 border-b text-left">Name</th>
                            <th className="py-2 px-4 border-b text-left">Role</th>
                            <th className="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {users.data.map((user) => (
                            <tr key={user.id} className="hover:bg-gray-50">
                                <td className="py-2 px-4 border-b text-left">{user.id}</td>
                                <td className="py-2 px-4 border-b text-left">{user.name}</td>
                                <td className="py-2 px-4 border-b text-left">{user.role}</td>
                                <td className="py-2 px-4 border-b flex justify-center space-x-4">
                                    <Link
                                        href={route("users.edit", user.id)}
                                        className="text-blue-500 hover:text-blue-700"
                                    >
                                        <FaEdit />
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(user.id)}
                                        className="text-red-500 hover:text-red-700"
                                    >
                                        <FaTrash />
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <div className="mt-4 flex justify-center">
                    <Pagination data={users} />
                </div>
            </div>

            {/* Delete Confirmation Modal */}
            <DeleteModal
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                onConfirm={confirmDelete}
            />

            {/* Add User Button */}
            <button
                onClick={() => window.location.href = route("users.create")}
                className="fixed bottom-14 right-4 md:bottom-8 md:right-8 lg:right-16 text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 rounded-full p-4"
            >
                <FaPlus className="w-8 h-8" />
            </button>
        </AuthenticatedLayout>
    );
}
