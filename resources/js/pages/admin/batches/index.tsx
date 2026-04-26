import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle, 
    CardDescription 
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
    DialogTrigger 
} from '@/Components/ui/dialog';
import { 
    Select, 
    SelectContent, 
    SelectItem, 
    SelectTrigger, 
    SelectValue 
} from '@/Components/ui/select';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Switch } from '@/Components/ui/switch';
import { 
    Plus, 
    Pencil, 
    Trash2, 
    Calendar,
    AlertCircle
} from 'lucide-react';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { cn } from '@/lib/utils';

interface Batch {
    id: number;
    academic_year_id: number;
    academic_year_name: string;
    name: string;
    start_date: string;
    end_date: string;
    is_active: boolean;
}

interface AcademicYear {
    id: number;
    name: string;
    is_active: boolean;
}

interface Props {
    batches: Batch[];
    academicYears: AcademicYear[];
}

export default function BatchIndex({ batches, academicYears }: Props) {
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const [editingBatch, setEditingBatch] = useState<Batch | null>(null);

    const { data, setData, post, put, delete: destroy, processing, errors, reset, clearErrors } = useForm({
        academic_year_id: '',
        name: '',
        start_date: '',
        end_date: '',
        is_active: true,
    });

    const openCreateDialog = () => {
        setEditingBatch(null);
        reset();
        clearErrors();
        
        // Auto-select active academic year if exists
        const activeYear = academicYears.find(year => year.is_active);
        if (activeYear) {
            setData('academic_year_id', activeYear.id.toString());
        }
        
        setIsDialogOpen(true);
    };

    const openEditDialog = (batch: Batch) => {
        setEditingBatch(batch);
        setData({
            academic_year_id: batch.academic_year_id.toString(),
            name: batch.name,
            start_date: batch.start_date,
            end_date: batch.end_date,
            is_active: batch.is_active,
        });
        clearErrors();
        setIsDialogOpen(true);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (editingBatch) {
            put(route('admin.batches.update', editingBatch.id), {
                onSuccess: () => setIsDialogOpen(false),
            });
        } else {
            post(route('admin.batches.store'), {
                onSuccess: () => {
                    setIsDialogOpen(false);
                    reset();
                },
            });
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Apakah Anda yakin ingin menghapus gelombang ini?')) {
            destroy(route('admin.batches.destroy', id));
        }
    };

    return (
        <AdminLayout>
            <Head title="Manajemen Gelombang" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold tracking-tight text-slate-900">Gelombang Pendaftaran</h2>
                        <p className="text-slate-500 text-sm">Kelola periode pembukaan pendaftaran siswa baru.</p>
                    </div>
                    <Button onClick={openCreateDialog} className="bg-indigo-600 hover:bg-indigo-700">
                        <Plus className="h-4 w-4 mr-2" /> Tambah Gelombang
                    </Button>
                </div>

                <Card className="border-none shadow-sm overflow-hidden">
                    <CardHeader className="bg-white border-b border-slate-100">
                        <div className="flex items-center justify-between">
                            <CardTitle className="text-base font-semibold">Daftar Gelombang</CardTitle>
                            <Badge variant="outline" className="text-slate-500 font-normal">
                                Total: {batches.length}
                            </Badge>
                        </div>
                    </CardHeader>
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-slate-50/50 hover:bg-slate-50/50">
                                    <TableHead className="w-[200px]">Nama Gelombang</TableHead>
                                    <TableHead>Tahun Ajaran</TableHead>
                                    <TableHead>Periode</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {batches.length > 0 ? (
                                    batches.map((batch) => (
                                        <TableRow key={batch.id} className="group transition-colors hover:bg-slate-50/50">
                                            <TableCell className="font-medium text-slate-900">
                                                {batch.name}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    <Calendar className="h-3.5 w-3.5 text-slate-400" />
                                                    <span className="text-slate-600 text-sm">{batch.academic_year_name}</span>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <span className="text-slate-600 text-sm italic">
                                                    {batch.start_date} s/d {batch.end_date}
                                                </span>
                                            </TableCell>
                                            <TableCell>
                                                <Badge 
                                                    className={cn(
                                                        "font-normal",
                                                        batch.is_active 
                                                            ? "bg-green-100 text-green-700 border-green-200" 
                                                            : "bg-slate-100 text-slate-600 border-slate-200"
                                                    )}
                                                >
                                                    {batch.is_active ? 'Aktif' : 'Nonaktif'}
                                                </Badge>
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger asChild>
                                                        <Button variant="ghost" size="icon" className="h-8 w-8 text-slate-500">
                                                            <Plus className="h-4 w-4 rotate-45 transform" />
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent align="end" className="w-40">
                                                        <DropdownMenuItem onClick={() => openEditDialog(batch)}>
                                                            <Pencil className="h-4 w-4 mr-2" /> Edit
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem 
                                                            className="text-red-600 focus:text-red-600 focus:bg-red-50"
                                                            onClick={() => handleDelete(batch.id)}
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
                                        <TableCell colSpan={5} className="h-24 text-center">
                                            <div className="flex flex-col items-center justify-center text-slate-500">
                                                <AlertCircle className="h-8 w-8 mb-2 opacity-20" />
                                                <p>Belum ada data gelombang.</p>
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
                            <DialogTitle>{editingBatch ? 'Edit Gelombang' : 'Tambah Gelombang Baru'}</DialogTitle>
                            <DialogDescription>
                                Isi formulir di bawah ini untuk mengelola periode gelombang pendaftaran.
                            </DialogDescription>
                        </DialogHeader>
                        
                        <div className="grid gap-4 py-4">
                            <div className="grid gap-2">
                                <Label htmlFor="academic_year_id">Tahun Ajaran</Label>
                                <Select 
                                    value={data.academic_year_id} 
                                    onValueChange={(val) => setData('academic_year_id', val)}
                                >
                                    <SelectTrigger className={errors.academic_year_id ? "border-red-500" : ""}>
                                        <SelectValue placeholder="Pilih Tahun Ajaran" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {academicYears.map((year) => (
                                            <SelectItem key={year.id} value={year.id.toString()}>
                                                {year.name} {year.is_active && '(Aktif)'}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.academic_year_id && <p className="text-xs text-red-500">{errors.academic_year_id}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="name">Nama Gelombang</Label>
                                <Input 
                                    id="name" 
                                    placeholder="Contoh: Gelombang 1" 
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={errors.name ? "border-red-500" : ""}
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
                                        className={errors.start_date ? "border-red-500" : ""}
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
                                        className={errors.end_date ? "border-red-500" : ""}
                                    />
                                    {errors.end_date && <p className="text-xs text-red-500">{errors.end_date}</p>}
                                </div>
                            </div>

                            <div className="flex items-center justify-between p-3 rounded-lg border border-slate-100 bg-slate-50/50 mt-2">
                                <div className="space-y-0.5">
                                    <Label className="text-sm">Status Aktif</Label>
                                    <p className="text-[10px] text-slate-500 italic">Pendaftar hanya bisa memilih gelombang yang aktif.</p>
                                </div>
                                <Switch 
                                    checked={data.is_active}
                                    onCheckedChange={(checked) => setData('is_active', checked)}
                                />
                            </div>
                        </div>

                        <DialogFooter>
                            <Button type="button" variant="outline" onClick={() => setIsDialogOpen(false)}>Batal</Button>
                            <Button type="submit" className="bg-indigo-600 hover:bg-indigo-700 font-semibold" disabled={processing}>
                                {editingBatch ? 'Simpan Perubahan' : 'Proses Simpan'}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </AdminLayout>
    );
}
