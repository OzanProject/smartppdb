import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';
import { 
    Table, 
    TableBody, 
    TableCell, 
    TableHead, 
    TableHeader, 
    TableRow 
} from '@/Components/ui/table';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { 
    Search, 
    Eye, 
    CheckCircle2, 
    Clock, 
    XCircle,
    MoreHorizontal
} from 'lucide-react';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { Badge } from '@/Components/ui/badge';

interface Registration {
    id: number;
    registration_number: string;
    status: 'pending' | 'verified' | 'accepted' | 'rejected';
    created_at: string;
    user: {
        name: string;
        email: string;
    };
    admission_batch: {
        name: string;
    };
}

interface PageProps {
    registrations: {
        data: Registration[];
        links: any[];
    };
}

export default function RegistrationIndex({ registrations }: PageProps) {
    const getStatusBadge = (status: string) => {
        const styles = {
            pending: 'bg-yellow-100 text-yellow-700 border-yellow-200',
            verified: 'bg-blue-100 text-blue-700 border-blue-200',
            accepted: 'bg-green-100 text-green-700 border-green-200',
            rejected: 'bg-red-100 text-red-700 border-red-200',
        };
        return styles[status as keyof typeof styles] || 'bg-gray-100 text-gray-700';
    };

    return (
        <AdminLayout>
            <Head title="Manajemen Pendaftaran" />
            
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold tracking-tight text-slate-900">Daftar Pendaftar</h2>
                        <p className="text-sm text-slate-500">Kelola dan verifikasi data calon siswa baru.</p>
                    </div>
                </div>

                <Card>
                    <CardHeader className="pb-3 border-b">
                        <div className="flex items-center justify-between">
                            <CardTitle className="text-base font-medium">Semua Pendaftaran</CardTitle>
                            <div className="relative w-72">
                                <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-slate-400" />
                                <Input
                                    type="search"
                                    placeholder="Cari nama atau nomor..."
                                    className="pl-9 h-9"
                                />
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-slate-50/50">
                                    <TableHead className="w-[150px]">No. Registrasi</TableHead>
                                    <TableHead>Nama Calon Siswa</TableHead>
                                    <TableHead>Gelombang</TableHead>
                                    <TableHead>Tanggal</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {registrations.data.length > 0 ? (
                                    registrations.data.map((reg) => (
                                        <TableRow key={reg.id} className="hover:bg-slate-50/50 border-b last:border-0">
                                            <TableCell className="font-mono text-xs font-bold text-slate-600">
                                                {reg.registration_number}
                                            </TableCell>
                                            <TableCell>
                                                <div className="font-medium text-slate-900">{reg.user.name}</div>
                                                <div className="text-xs text-slate-500">{reg.user.email}</div>
                                            </TableCell>
                                            <TableCell>
                                                <span className="text-sm text-slate-600">{reg.admission_batch.name}</span>
                                            </TableCell>
                                            <TableCell className="text-sm text-slate-600">
                                                {new Date(reg.created_at).toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'short',
                                                    year: 'numeric'
                                                })}
                                            </TableCell>
                                            <TableCell>
                                                <div className={`inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border ${getStatusBadge(reg.status)}`}>
                                                    {reg.status}
                                                </div>
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <Button variant="ghost" size="sm" asChild>
                                                    <Link href={route('admin.registrations.show', reg.id)}>
                                                        <Eye className="h-4 w-4 mr-1" /> Detail
                                                    </Link>
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={6} className="h-32 text-center text-slate-500">
                                            Belum ada data pendaftar.
                                        </TableCell>
                                    </TableRow>
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </AdminLayout>
    );
}
