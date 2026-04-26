import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle 
} from '@/Components/ui/card';
import { 
    Table, 
    TableBody, 
    TableCell, 
    TableHead, 
    TableHeader, 
    TableRow 
} from '@/Components/ui/table';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { 
    Users, 
    Eye, 
    FileText,
    Calendar,
    GraduationCap,
    Download
} from 'lucide-react';

interface Student {
    id: number;
    user: {
        name: string;
        email: string;
    };
    admission_batch: {
        name: string;
        academic_year: {
            name: string;
        };
    };
    registration_number: string;
    status: string;
}

interface Props {
    students: {
        data: Student[];
        links: any;
        current_page: number;
    };
}

export default function StudentIndex({ students }: Props) {
    return (
        <AdminLayout>
            <Head title="Data Siswa" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold tracking-tight text-slate-900">Data Siswa</h2>
                        <p className="text-slate-500 text-sm">Daftar calon siswa yang telah dinyatakan diterima.</p>
                    </div>
                    <Button variant="outline" className="h-10 border-slate-200">
                        <Download className="h-4 w-4 mr-2" /> Ekspor Data
                    </Button>
                </div>

                <Card className="border-none shadow-sm overflow-hidden">
                    <CardHeader className="bg-white border-b border-slate-100 pb-4">
                        <div className="flex items-center justify-between">
                            <CardTitle className="text-base font-semibold">Siswa Diterima</CardTitle>
                            <Badge className="bg-indigo-50 text-indigo-600 hover:bg-indigo-50 border-indigo-100 font-medium">
                                Total: {students.data.length} Siswa
                            </Badge>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-slate-50/50">
                                    <TableHead className="px-6 py-4">Nomor Pendaftaran</TableHead>
                                    <TableHead>Nama Siswa</TableHead>
                                    <TableHead>Gelombang</TableHead>
                                    <TableHead>Tahun Ajaran</TableHead>
                                    <TableHead className="text-right px-6">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {students.data.length > 0 ? (
                                    students.data.map((student) => (
                                        <TableRow key={student.id} className="hover:bg-slate-50/50 transition-colors">
                                            <TableCell className="px-6 py-4 font-mono text-xs font-bold text-indigo-600">
                                                {student.registration_number}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex flex-col">
                                                    <span className="font-semibold text-slate-900">{student.user.name}</span>
                                                    <span className="text-xs text-slate-500">{student.user.email}</span>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    <Badge variant="outline" className="bg-slate-50 font-normal">
                                                        {student.admission_batch.name}
                                                    </Badge>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2 text-slate-600 text-sm">
                                                    <Calendar className="h-3.5 w-3.5 text-slate-400" />
                                                    {student.admission_batch.academic_year.name}
                                                </div>
                                            </TableCell>
                                            <TableCell className="text-right px-6">
                                                <Button asChild variant="ghost" size="sm" className="h-8 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50">
                                                    <Link href={route('admin.registrations.show', student.id)}>
                                                        <Eye className="h-4 w-4 mr-2" /> Detail
                                                    </Link>
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={5} className="h-32 text-center text-slate-500">
                                            <div className="flex flex-col items-center justify-center space-y-2">
                                                <GraduationCap className="h-8 w-8 opacity-20" />
                                                <p>Belum ada siswa yang dinyatakan diterima.</p>
                                            </div>
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
