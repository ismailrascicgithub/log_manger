import { Link } from '@inertiajs/react';

export default function Pagination({ data }) {
    const currentPage = data.current_page;
    const lastPage = data.last_page;
    const delta = 2;
    const range = [];
    const rangeWithDots = [];
    let l;

    for (let i = 1; i <= lastPage; i++) {
        if (i === 1 || i === lastPage || (i >= currentPage - delta && i <= currentPage + delta)) {
            range.push(i);
        }
    }

    for (let i of range) {
        if (l) {
            if (i - l === 2) {
                rangeWithDots.push(l + 1);
            } else if (i - l !== 1) {
                rangeWithDots.push('...');
            }
        }
        rangeWithDots.push(i);
        l = i;
    }

    return (
        <div className="flex justify-center items-center space-x-2">
            {rangeWithDots.map((page, index) =>
                page === '...' ? (
                    <span key={index} className="px-3 py-1 border rounded text-gray-500">
                        {page}
                    </span>
                ) : (
                    <Link
                        key={index}
                        href={`?page=${page}`}
                        className={`px-3 py-1 border rounded ${currentPage === page ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'}`}
                    >
                        {page}
                    </Link>
                )
            )}
        </div>
    );
}
