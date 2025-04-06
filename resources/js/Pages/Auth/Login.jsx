import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';

export default function Login({ status }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title="Prijava" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit} className="sm:max-w-4xl mx-auto">
                <div className="py-4 text-base leading-6 space-y-6 text-gray-700 sm:text-lg sm:leading-7">
                    <div className="relative mt-4">
                        <TextInput
                            id="email"
                            type="text"
                            name="email"
                            value={data.email}
                            className="peer placeholder-transparent h-10 w-full border-b-2 border-t-0 border-r-0 border-l-0 text-gray-900 focus:outline-none focus:border-b-sky-500 focus:mt-1 "
                            autoComplete="email"
                            isFocused={false}
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder="Korisnik"
                        />
                        <label htmlFor="email" className="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Korisnik</label>
                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="relative mt-4">
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="peer placeholder-transparent h-10 w-full border-b-2 border-t-0 border-r-0 border-l-0 text-gray-900 focus:outline-none focus:border-b-sky-500 focus:mt-1 "
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="Šifra"
                        />
                        <label htmlFor="password" className="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Šifra</label>
                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="block mt-4">
                        <label className="flex items-center">
                            <Checkbox
                                name="remember"
                                className="text-sky-600 focus:ring-sky-500"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                            />
                            <span className="ml-2 text-sm text-gray-600">Zapamti me</span>
                        </label>
                    </div>

                    <div className="relative mt-4">
                        <PrimaryButton className="bg-gradient-to-r from-cyan-400 to-sky-500 text-white rounded-md px-4 py-2" disabled={processing}>
                            Prijavi se
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </GuestLayout>
    );
}
