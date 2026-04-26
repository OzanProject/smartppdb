import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { 
    Users, 
    Clock, 
    CheckCircle2, 
    GraduationCap, 
    Calendar,
    School as SchoolIcon,
    AlertCircle,
    ArrowRight
} from 'lucide-react';

interface UserProps {
    name: string;
    role: string;
}

interface SchoolProps {
    name: string;
    npsn: string;
    education_level_name: string;
    education_level_code: string;
    address: string;
    is_registration_open: boolean;
    email: string;
    phone: string;
}

interface AcademicYearProps {
    name: string;
    start_date: string;
    end_date: string;
}

interface Stats {
    registrations_count: number;
    pending_count: number;
    verified_count: number;
    accepted_count: number;
}

interface DashboardProps {
    user: UserProps;
    school: SchoolProps;
    activeAcademicYear: AcademicYearProps;
    activeAdmissionBatches: any[];
    stats: Stats;
}

export default function AdminDashboard({
    user,
    school,
    activeAcademicYear,
    activeAdmissionBatches,
    stats,
}: DashboardProps) {
    const statCards = [
        {
            title: 'Total Pendaftar',
            value: stats?.registrations_count || 0,
            icon: Users,
            color: 'text-blue-600',
            bg: 'bg-blue-100',
            description: 'Semua pendaftar masuk'
        },
        {
            title: 'Menunggu Verifikasi',
            value: stats?.pending_count || 0,
            icon: Clock,
            color: 'text-yellow-600',
            bg: 'bg-yellow-100',
            description: 'Tahap pemeriksaan'
        },
        {
            title: 'Terverifikasi',
            value: stats?.verified_count || 0,
            icon: CheckCircle2,
            color: 'text-indigo-600',
            bg: 'bg-indigo-100',
            description: 'Data sudah benar'
        },
        {
            title: 'Diterima',
            value: stats?.accepted_count || 0,
            icon: GraduationCap,
            color: 'text-green-600',
            bg: 'bg-green-100',
            description: 'Siswa baru resmi'
        },
    ];

    return (
        <AdminLayout>
            <Head title="Admin Dashboard" />

            <div className="space-y-8">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-3xl font-bold tracking-tight text-slate-900">Dashboard Overview</h2>
                        <p className="text-slate-500">Selamat datang kembali di sistem PPDB Pro.</p>
                    </div>
                    <div className="flex items-center gap-2">
                        <Badge variant={school?.is_registration_open ? 'default' : 'destructive'} className="px-3 py-1 bg-green-100 text-green-700 border-green-200">
                            {school?.is_registration_open ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup'}
                        </Badge>
                    </div>
                </div>

                <div className="space-y-6">
                    {/* Stats Grid */}
                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
                        {statCards.map((stat, index) => (
                            <Card key={index} className="border-none shadow-sm h-full hover:shadow-md transition-shadow">
                                <CardHeader className="flex flex-row items-center justify-between pb-2">
                                    <CardTitle className="text-sm font-medium text-slate-500">{stat.title}</CardTitle>
                                    <div className={`p-2 rounded-lg ${stat.bg}`}>
                                        <stat.icon className={`h-4 w-4 ${stat.color}`} />
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-slate-900">{stat.value}</div>
                                    <p className="text-xs text-slate-500 mt-1">{stat.description}</p>
                                </CardContent>
                            </Card>
                        ))}
                    </div>

                    <div className="grid gap-6 md:grid-cols-1 lg:grid-cols-2">
                        {/* School Info Card */}
                        <Card className="border-none shadow-sm">
                            <CardHeader className="bg-slate-50/50">
                                <CardTitle className="text-base font-semibold text-slate-900 flex items-center">
                                    <SchoolIcon className="h-5 w-5 mr-2 text-indigo-600" />
                                    Informasi Sekolah
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 space-y-4">
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-1">
                                        <p className="text-xs font-bold text-slate-400 uppercase">NPSN</p>
                                        <p className="text-sm font-medium">{school?.npsn || '-'}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <p className="text-xs font-bold text-slate-400 uppercase">Jenjang</p>
                                        <p className="text-sm font-medium">{school?.education_level_name || '-'}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <p className="text-xs font-bold text-slate-400 uppercase">Email</p>
                                        <p className="text-sm font-medium">{school?.email || '-'}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <p className="text-xs font-bold text-slate-400 uppercase">Telepon</p>
                                        <p className="text-sm font-medium">{school?.phone || '-'}</p>
                                    </div>
                                </div>
                                <div className="space-y-1">
                                    <p className="text-xs font-bold text-slate-400 uppercase">Alamat</p>
                                    <p className="text-sm font-medium line-clamp-2">{school?.address || '-'}</p>
                                </div>
                                <div className="pt-2">
                                    <Button variant="outline" size="sm" className="w-full justify-between" asChild>
                                        <Link href={route('admin.school.edit')}>
                                            Edit Profil Sekolah <ArrowRight className="h-4 w-4" />
                                        </Link>
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Academic Year & Batches Info */}
                        <Card className="border-none shadow-sm h-full">
                            <CardHeader className="bg-slate-50/50">
                                <CardTitle className="text-base font-semibold text-slate-900 flex items-center">
                                    <AlertCircle className="h-5 w-5 mr-2 text-indigo-600" />
                                    Konfigurasi PPDB
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 space-y-6">
                                <div className="flex items-center justify-between p-4 rounded-xl bg-indigo-50/50 border border-indigo-100">
                                    <div className="flex items-center space-x-3">
                                        <div className="p-2 bg-indigo-100 rounded-lg">
                                            <Calendar className="h-5 w-5 text-indigo-600" />
                                        </div>
                                        <div>
                                            <p className="text-sm font-bold text-indigo-900">{activeAcademicYear?.name || 'Musim Belum Diatur'}</p>
                                            <p className="text-[10px] text-indigo-700/70 uppercase tracking-wider">Tahun Ajaran Aktif</p>
                                        </div>
                                    </div>
                                    <Badge className="bg-indigo-600 hover:bg-indigo-700 text-white border-0">Aktif</Badge>
                                </div>
                                
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between">
                                        <p className="text-xs font-bold text-slate-400 uppercase tracking-wider">Gelombang Aktif</p>
                                        <div className="h-[1px] flex-1 bg-slate-100 mx-4"></div>
                                    </div>
                                    {activeAdmissionBatches && activeAdmissionBatches.length > 0 ? (
                                        <div className="grid gap-2">
                                            {activeAdmissionBatches.map(batch => (
                                                <div key={batch.id} className="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:bg-slate-50 transition-colors">
                                                    <div className="flex items-center text-sm font-medium text-slate-700">
                                                        <div className="h-2 w-2 rounded-full bg-green-500 mr-3 animate-pulse"></div>
                                                        {batch.name}
                                                    </div>
                                                    <p className="text-[10px] text-slate-500">{batch.start_date} sd {batch.end_date}</p>
                                                </div>
                                            ))}
                                        </div>
                                    ) : (
                                        <div className="py-4 text-center rounded-lg border border-dashed border-slate-200">
                                            <p className="text-xs text-slate-400 italic">Tidak ada gelombang pendaftaran yang aktif saat ini.</p>
                                        </div>
                                    )}
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}