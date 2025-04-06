import React from 'react';
import { useForm, Link } from '@inertiajs/react';

export default function ProjectForm({
  className,
  project = null,
  isCreating,
  isAdmin,
  users = [],
  currentUserId
}) {
  const initialData = {
    name: project?.name || '',
    description: project?.description || '',
  };

  if (isAdmin) {
    initialData.user_id = project?.user_id || currentUserId;
  }

  const { data, setData, post, put, processing, errors } = useForm(initialData);

  const handleSubmit = (e) => {
    e.preventDefault();
    const formData = { ...data };

    if (!isAdmin) {
      formData.user_id = currentUserId;
    }

    if (isCreating) {
      post(route("projects.store"), formData);
    } else {
      put(route("projects.update", project.id), formData);
    }
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
          <label htmlFor="description" className="block text-gray-700 mb-2">Description</label>
          <textarea
            id="description"
            value={data.description}
            onChange={(e) => setData('description', e.target.value)}
            className="w-full border border-gray-300 rounded p-2"
            rows="4"
          />
          {errors.description && <div className="text-red-600 text-sm mt-1">{errors.description}</div>}
        </div>

        {isAdmin && (
          <div className="mb-4">
            <label htmlFor="user_id" className="block text-gray-700 mb-2">Assign to User</label>
            <select
              id="user_id"
              value={data.user_id}
              onChange={(e) => setData('user_id', e.target.value)}
              className="w-full border border-gray-300 rounded p-2"
            >
              <option value={currentUserId}>Role ({users.find(u => u.id === currentUserId)?.name})</option>
              {users.filter(user => user.id !== currentUserId).map((user) => (
                <option key={user.id} value={user.id}>{user.name}</option>
              ))}
            </select>
            {errors.user_id && <div className="text-red-600 text-sm mt-1">{errors.user_id}</div>}
          </div>
        )}

        <div className="flex items-center justify-end mt-6">
          <button
            type="submit"
            disabled={processing}
            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
          >
            {isCreating ? 'Create Project' : 'Update Project'}
          </button>
          <Link
            href={route("projects.index")}
            className="ml-4 text-gray-600 hover:underline"
          >
            Cancel
          </Link>
        </div>
      </form>
    </div>
  );
}