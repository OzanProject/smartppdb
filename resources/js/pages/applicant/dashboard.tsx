import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { ClipboardList, FileText, User, CheckCircle2, Clock } from 'lucide-react';

type RegistrationProps = {
    id: number;
    registration_number: string;
    status: 'pending' | 'verified' | 'accepted' | 'rejected';
    created_at: string;
} | null;

type Props = {
    auth: {
        user: {
            name: string;
            email: string;
        };
    };
    registration: RegistrationProps;
};

export default function Dashboard({ auth, registration }: Props) {
    const statusMap = {
        pending: { label: 'Menunggu Verifikasi', color: 'bg-yellow-100 text-yellow-800 border-yellow-200', icon: Clock },
        verified: { label: 'Terverifikasi', color: 'bg-blue-100 text-blue-800 border-blue-200', icon: ClipboardList },
        accepted: { label: 'Diterima', color: 'bg-green-100 text-green-800 border-green-200', icon: CheckCircle2 },
        rejected: { label: 'Ditolak', color: 'bg-red-100 text-red-800 border-red-200', icon: ClipboardList },
    };

    const currentStatus = registration ? statusMap[registration.status] : null;
    const StatusIcon = currentStatus?.icon || Clock;

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Dashboard Pendaftar</h2>}
        >
            <Head title="Applicant Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {!registration ? (
                        <Card className="border-none shadow-sm overflow-hidden bg-gradient-to-br from-indigo-50 to-white">
                            <CardHeader className="pb-4">
                                <CardTitle className="text-2xl text-indigo-900">Selamat Datang, {auth.user.name}!</CardTitle>
                                <CardDescription className="text-indigo-700/70">
                                    Anda belum melengkapi pendaftaran. Silakan mulai pendaftaran Anda sekarang.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="flex flex-col md:flex-row gap-6 items-center">
                                    <div className="flex-1 space-y-4">
                                        <p className="text-slate-600">
                                            Proses pendaftaran terdiri dari beberapa tahap: Pengisian Biodata, 
                                            Data Orang Tua, Alamat, dan Unggah Dokumen persyaratan.
                                        </p>
                                        <div className="flex gap-4">
                                            <Link
                                                href={route('dashboard')} // Placeholder 
                                                className="inline-flex items-center justify-center rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                            >
                                                Mulai Pendaftaran <ClipboardList className="ml-2 h-4 w-4" />
                                            </Link>
                                        </div>
                                    </div>
                                    <div className="hidden md:block">
                                        <div className="w-48 h-48 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <FileText className="h-24 w-24 text-indigo-400" />
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid gap-6 md:grid-cols-3">
                            <Card className="md:col-span-2 border-none shadow-sm">
                                <CardHeader>
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <CardTitle>Status Pendaftaran</CardTitle>
                                            <CardDescription>Nomor Registrasi: {registration.registration_number}</CardDescription>
                                        </div>
                                        <Badge className={`${currentStatus?.color} border px-3 py-1`}>
                                            {currentStatus?.label}
                                        </Badge>
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <div className="relative">
                                        <div className="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-100" />
                                        
                                        <div className="space-y-8 relative">
                                            <div className="flex gap-4">
                                                <div className="z-10 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                                                    <CheckCircle2 className="h-5 w-5" />
                                                </div>
                                                <div>
                                                    <p className="font-semibold text-slate-900">Pendaftaran Berhasil</p>
                                                    <p className="text-sm text-slate-500">Anda telah berhasil membuat akun dan memulai registrasi.</p>
                                                </div>
                                            </div>

                                            <div className="flex gap-4">
                                                <div className={`z-10 flex h-8 w-8 items-center justify-center rounded-full ${registration.status !== 'pending' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-400'}`}>
                                                    <StatusIcon className="h-5 w-5" />
                                                </div>
                                                <div>
                                                    <p className={`font-semibold ${registration.status !== 'pending' ? 'text-slate-900' : 'text-slate-500'}`}>
                                                        {currentStatus?.label}
                                                    </p>
                                                    <p className="text-sm text-slate-500">Proses saat ini adalah peninjauan data oleh tim admin.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>

                            <Card className="border-none shadow-sm">
                                <CardHeader>
                                    <CardTitle>Aksi Cepat</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <Link
                                        href={route('profile.edit')}
                                        className="flex items-center w-full px-4 py-2 text-sm font-medium text-slate-700 bg-slate-50 rounded-lg hover:bg-slate-100"
                                    >
                                        <User className="mr-3 h-4 w-4" /> Edit Profil Akun
                                    </Link>
                                    <button
                                        className="flex items-center w-full px-4 py-2 text-sm font-medium text-slate-700 bg-slate-50 rounded-lg hover:bg-slate-100"
                                    >
                                        <FileText className="mr-3 h-4 w-4" /> Lihat Bukti Daftar
                                    </button>
                                </CardContent>
                            </Card>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}