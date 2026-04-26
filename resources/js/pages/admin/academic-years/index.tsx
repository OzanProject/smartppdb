import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle, 
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
    Dialog, 
    DialogContent, 
    DialogDescription, 
    DialogFooter, 
    DialogHeader, 
    DialogTitle, 
} from '@/Components/ui/dialog';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Switch } from '@/Components/ui/switch';
import { 
    Plus, 
    Pencil, 
    Trash2, 
    Calendar,
    AlertCircle,
    MoreVertical
} from 'lucide-react';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { cn } from '@/lib/utils';

interface AcademicYear {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    is_active: boolean;
}

interface Props {
    academicYears: AcademicYear[];
}

export default function AcademicYearIndex({ academicYears }: Props) {
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const [editingYear, setEditingYear] = useState<AcademicYear | null>(null);

    const { data, setData, post, put, delete: destroy, processing, errors, reset, clearErrors } = useForm({
        name: '',
        start_date: '',
        end_date: '',
        is_active: false,
    });

    const openCreateDialog = () => {
        setEditingYear(null);
        reset();
        clearErrors();
        setIsDialogOpen(true);
    };

    const openEditDialog = (year: AcademicYear) => {
        setEditingYear(year);
        setData({
            name: year.name,
            start_date: year.start_date,
            end_date: year.end_date,
            is_active: year.is_active,
        });
        clearErrors();
        setIsDialogOpen(true);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (editingYear) {
            put(route('admin.academic-years.update', editingYear.id), {
                onSuccess: () => setIsDialogOpen(false),
            });
        } else {
            post(route('admin.academic-years.store'), {
                onSuccess: () => {
                    setIsDialogOpen(false);
                    reset();
                },
            });
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')) {
            destroy(route('admin.academic-years.destroy', id));
        }
    };

    return (
        <AdminLayout>
            <Head title="Manajemen Tahun Ajaran" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold tracking-tight text-slate-900">Tahun Ajaran</h2>
                        <p className="text-slate-500 text-sm">Kelola periode akademik untuk pendaftaran siswa baru.</p>
                    </div>
                    <Button onClick={openCreateDialog} className="bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                        <Plus className="h-4 w-4 mr-2" /> Tambah Tahun Ajaran
                    </Button>
                </div>

                <Card className="border-none shadow-sm overflow-hidden">
                    <CardHeader className="bg-white border-b border-slate-100 pb-4">
                        <div className="flex items-center justify-between">
                            <CardTitle className="text-base font-semibold">Daftar Tahun Ajaran</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-slate-50/50">
                                    <TableHead className="px-6 py-4">Nama Tahun Ajaran</TableHead>
                                    <TableHead>Periode Mulai</TableHead>
                                    <TableHead>Periode Selesai</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead className="text-right px-6">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {academicYears.length > 0 ? (
                                    academicYears.map((year) => (
                                        <TableRow key={year.id} className="hover:bg-slate-50/50 transition-colors">
                                            <TableCell className="px-6 py-4 font-medium text-slate-900">
                                                {year.name}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2 text-slate-600">
                                                    <Calendar className="h-4 w-4 text-slate-400" />
                                                    {year.start_date}
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2 text-slate-600">
                                                    <Calendar className="h-4 w-4 text-slate-400" />
                                                    {year.end_date}
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <Badge 
                                                    className={cn(
                                                        "font-normal",
                                                        year.is_active 
                                                            ? "bg-green-100 text-green-700 hover:bg-green-100 border-green-200" 
                                                            : "bg-slate-100 text-slate-500 hover:bg-slate-100 border-slate-200"
                                                    )}
                                                >
                                                    {year.is_active ? 'Aktif' : 'Nonaktif'}
                                                </Badge>
                                            </TableCell>
                                            <TableCell className="text-right px-6">
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger asChild>
                                                        <Button variant="ghost" size="icon" className="h-8 w-8 text-slate-400 hover:text-slate-900">
                                                            <MoreVertical className="h-4 w-4" />
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent align="end" className="w-40">
                                                        <DropdownMenuItem onClick={() => openEditDialog(year)} className="cursor-pointer">
                                                            <Pencil className="h-4 w-4 mr-2" /> Edit
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem 
                                                            onClick={() => handleDelete(year.id)}
                                                            className="text-red-600 focus:text-red-600 focus:bg-red-50 cursor-pointer"
                                                        >
                                                            <Trash2 className="h-4 w-4 mr-2" /> Hapus
                                                        </DropdownMenuItem>
                                                    </DropdownMenuContent>
                                                </DropdownMenu>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={5} className="h-32 text-center text-slate-500">
                                            <div className="flex flex-col items-center justify-center space-y-2">
                                                <AlertCircle className="h-8 w-8 opacity-20" />
                                                <p>Belum ada data tahun ajaran.</p>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>

            <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <form onSubmit={handleSubmit}>
                        <DialogHeader>
                            <DialogTitle>{editingYear ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran'}</DialogTitle>
                            <DialogDescription>
                                Masukkan rincian tahun ajaran baru untuk sistem pendaftaran.
                            </DialogDescription>
                        </DialogHeader>
                        
                        <div className="grid gap-5 py-6">
                            <div className="grid gap-2">
                                <Label htmlFor="name">Nama Tahun Ajaran</Label>
                                <Input 
                                    id="name" 
                                    placeholder="Contoh: 2024/2025" 
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={cn("h-10", errors.name && "border-red-500 focus-visible:ring-red-500")}
                                />
                                {errors.name && <p className="text-xs text-red-500">{errors.name}</p>}
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div className="grid gap-2">
                                    <Label htmlFor="start_date">Tanggal Mulai</Label>
                                    <Input 
                                        id="start_date" 
                                        type="date" 
                                        value={data.start_date}
                                        onChange={(e) => setData('start_date', e.target.value)}
                                        className={cn("h-10", errors.start_date && "border-red-500 focus-visible:ring-red-500")}
                                    />
                                    {errors.start_date && <p className="text-xs text-red-500">{errors.start_date}</p>}
                                </div>
                                <div className="grid gap-2">
                                    <Label htmlFor="end_date">Tanggal Selesai</Label>
                                    <Input 
                                        id="end_date" 
                                        type="date" 
                                        value={data.end_date}
                                        onChange={(e) => setData('end_date', e.target.value)}
                                        className={cn("h-10", errors.end_date && "border-red-500 focus-visible:ring-red-500")}
                                    />
                                    {errors.end_date && <p className="text-xs text-red-500">{errors.end_date}</p>}
                                </div>
                            </div>

                            <div className="flex items-center justify-between space-x-2 rounded-xl border border-slate-100 bg-slate-50/50 p-4 transition-all">
                                <div className="space-y-0.5">
                                    <Label className="text-sm font-semibold">Tahun Ajaran Aktif</Label>
                                    <p className="text-[11px] text-slate-500 leading-tight">
                                        Menjadikan tahun ini sebagai periode aktif utama. Tahun lain akan otomatis dinonaktifkan.
                                    </p>
                                </div>
                                <Switch 
                                    checked={data.is_active}
                                    onCheckedChange={(checked) => setData('is_active', checked)}
                                />
                            </div>
                        </div>

                        <DialogFooter>
                            <Button type="button" variant="outline" onClick={() => setIsDialogOpen(false)} className="h-10">
                                Batal
                            </Button>
                            <Button type="submit" disabled={processing} className="h-10 bg-indigo-600 hover:bg-indigo-700 min-w-[100px]">
                                {editingYear ? 'Simpan' : 'Tambah'}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </AdminLayout>
    );
}
