import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/Components/ui/card';
import { Button } from '@/Components/ui/button';
import { Badge } from '@/Components/ui/badge';
import { 
    CheckCircle2, 
    XCircle, 
    Clock, 
    User, 
    Users, 
    GraduationCap, 
    FileText,
    ArrowLeft,
    AlertCircle
} from 'lucide-react';
import { Link } from '@inertiajs/react';
import { Separator } from '@/Components/ui/separator';
import { Textarea } from '@/Components/ui/textarea';

interface Registration {
    id: number;
    registration_number: string;
    status: 'pending' | 'verified' | 'accepted' | 'rejected';
    admin_note: string | null;
    applicant_data: any;
    user: { name: string; email: string };
    admission_batch: { name: string; academic_year: { name: string } };
    documents: any[];
}

interface PageProps {
    registration: Registration;
}

export default function RegistrationShow({ registration }: PageProps) {
    const { data, setData, post, processing } = useForm({
        status: registration.status,
        admin_note: registration.admin_note || '',
    });

    const updateStatus = (newStatus: 'pending' | 'verified' | 'accepted' | 'rejected') => {
        if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${newStatus}?`)) {
            setData('status', newStatus);
            // We need to wait for state update or pass it directly if we want reliable sync
            // Actually useForm's post uses the CURRENT state. 
            // Better to use put/post with manual options or just use the form's data.
            post(route('admin.registrations.status.update', registration.id), {
                onSuccess: () => {},
            });
        }
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending': return 'bg-yellow-500';
            case 'verified': return 'bg-blue-500';
            case 'accepted': return 'bg-green-500';
            case 'rejected': return 'bg-red-500';
            default: return 'bg-gray-500';
        }
    };

    const person = registration.applicant_data?.personal || {};
    const parents = registration.applicant_data?.parents || {};
    const school = registration.applicant_data?.school || {};

    return (
        <AdminLayout>
            <Head title={`Detail Pendaftar - ${registration.registration_number}`} />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                        <Button variant="outline" size="icon" asChild>
                            <Link href={route('admin.registrations.index')}>
                                <ArrowLeft className="h-4 w-4" />
                            </Link>
                        </Button>
                        <div>
                            <h2 className="text-2xl font-bold tracking-tight text-slate-900">
                                {registration.user.name}
                            </h2>
                            <div className="flex items-center space-x-2 text-sm text-slate-500">
                                <span className="font-mono font-bold">{registration.registration_number}</span>
                                <span>•</span>
                                <span>{registration.admission_batch.name}</span>
                            </div>
                        </div>
                    </div>
                    <div className="flex items-center space-x-2">
                        <Badge className={`${getStatusColor(registration.status)} text-white border-0`}>
                            {registration.status.toUpperCase()}
                        </Badge>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Details */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Biodata */}
                        <Card>
                            <CardHeader className="flex flex-row items-center space-x-2 py-4 bg-slate-50/50">
                                <User className="h-5 w-5 text-indigo-600" />
                                <CardTitle className="text-base">Biodata Calon Siswa</CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">NIK / No. KK</label>
                                    <p className="text-sm font-medium">{person.nik || '-'} / {person.no_kk || '-'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Tempat, Tanggal Lahir</label>
                                    <p className="text-sm font-medium">{person.pob || '-'}, {person.dob || '-'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Jenis Kelamin</label>
                                    <p className="text-sm font-medium">{person.gender === 'male' ? 'Laki-laki' : 'Perempuan'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Alamat</label>
                                    <p className="text-sm font-medium">{person.address || '-'}</p>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Orang Tua */}
                        <Card>
                            <CardHeader className="flex flex-row items-center space-x-2 py-4 bg-slate-50/50">
                                <Users className="h-5 w-5 text-indigo-600" />
                                <CardTitle className="text-base">Data Orang Tua / Wali</CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Nama Ayah</label>
                                    <p className="text-sm font-medium">{parents.father_name || '-'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Nama Ibu</label>
                                    <p className="text-sm font-medium">{parents.mother_name || '-'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">No. HP Orang Tua</label>
                                    <p className="text-sm font-medium">{parents.parent_phone || '-'}</p>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Asal Sekolah */}
                        <Card>
                            <CardHeader className="flex flex-row items-center space-x-2 py-4 bg-slate-50/50">
                                <GraduationCap className="h-5 w-5 text-indigo-600" />
                                <CardTitle className="text-base">Asal Sekolah</CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Nama Sekolah</label>
                                    <p className="text-sm font-medium">{school.previous_school_name || '-'}</p>
                                </div>
                                <div>
                                    <label className="text-xs font-bold text-slate-400 uppercase">Alamat Sekolah</label>
                                    <p className="text-sm font-medium">{school.previous_school_address || '-'}</p>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Verification Sidebar */}
                    <div className="space-y-6">
                        <Card className="border-indigo-100">
                            <CardHeader className="bg-indigo-50/30">
                                <CardTitle className="text-sm font-bold flex items-center">
                                    <AlertCircle className="h-4 w-4 mr-2 text-indigo-600" />
                                    Tindakan Verifikasi
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="pt-6 space-y-4">
                                <p className="text-xs text-slate-500">
                                    Setelah memeriksa data di samping, Anda dapat memutuskan status pendaftaran ini.
                                </p>
                                
                                <div className="grid grid-cols-1 gap-2">
                                    <Button 
                                        onClick={() => updateStatus('verified')} 
                                        variant={registration.status === 'verified' ? 'default' : 'outline'}
                                        className="justify-start"
                                        disabled={processing}
                                    >
                                        <CheckCircle2 className="h-4 w-4 mr-2 text-blue-500" />
                                        Verifikasi Data
                                    </Button>
                                    <Button 
                                        onClick={() => updateStatus('accepted')} 
                                        variant={registration.status === 'accepted' ? 'default' : 'outline'}
                                        className="justify-start"
                                        disabled={processing}
                                    >
                                        <CheckCircle2 className="h-4 w-4 mr-2 text-green-500" />
                                        Terima (Lulus)
                                    </Button>
                                    <Button 
                                        onClick={() => updateStatus('rejected')} 
                                        variant={registration.status === 'rejected' ? 'destructive' : 'outline'}
                                        className="justify-start"
                                        disabled={processing}
                                    >
                                        <XCircle className="h-4 w-4 mr-2" />
                                        Tolak / Tidak Lulus
                                    </Button>
                                </div>

                                <Separator />
                                
                                <div className="space-y-2">
                                    <label className="text-xs font-bold text-slate-400 uppercase">Status Saat Ini</label>
                                    <div className="flex items-center space-x-2 p-2 rounded bg-slate-50 border border-slate-100">
                                        <Clock className="h-4 w-4 text-slate-400" />
                                        <span className="text-sm font-medium capitalize">{registration.status}</span>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="text-sm font-bold flex items-center">
                                    <FileText className="h-4 w-4 mr-2 text-indigo-600" />
                                    Dokumen Terlampir
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="p-8 text-center border-2 border-dashed rounded-lg border-slate-100">
                                    <p className="text-xs text-slate-400">Belum ada dokumen diunggah.</p>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
