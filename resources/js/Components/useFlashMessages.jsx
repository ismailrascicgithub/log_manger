import { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';

export default function useFlashMessages() {
    const { flash } = usePage().props;
    const [statusMessage, setStatusMessage] = useState({ type: '', message: '' });

    useEffect(() => {
        if (flash.message) {
            setStatusMessage({ type: 'success', message: flash.message });
            setTimeout(() => setStatusMessage({ type: '', message: '' }), 2000);
        }

        if (flash.error) {
            setStatusMessage({ type: 'error', message: flash.error });
            setTimeout(() => setStatusMessage({ type: '', message: '' }), 2000);
        }
    }, [flash]);

    return statusMessage;
}
