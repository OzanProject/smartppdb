import React, { useState, useRef } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle 
} from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Switch } from '@/Components/ui/switch';
import { Button } from '@/Components/ui/button';
import { 
    Save, 
    School, 
    Upload,
    Trash2,
    ImageIcon,
    Settings2,
    CheckCircle2,
    Loader2
} from 'lucide-react';
import { cn } from '@/lib/utils';

type SchoolProps = {
    id: number;
    name: string;
    slug: string;
    education_level_code: string | null;
    education_level_name: string;
    is_custom_level: boolean;
    npsn: string | null;
    email: string | null;
    phone: string | null;
    address: string | null;
    logo_url: string | null;
    is_registration_open: boolean;
};

type Props = {
    school: SchoolProps;
};

export default function Edit({ school }: Props) {
    const fileInputRef = useRef<HTMLInputElement>(null);
    const [logoPreview, setLogoPreview] = useState<string | null>(null);
    const [isDragging, setIsDragging] = useState(false);
    const [deletingLogo, setDeletingLogo] = useState(false);

    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        _method: 'PATCH' as string,
        name: school.name,
        slug: school.slug,
        education_level_code: school.education_level_code || '',
        education_level_name: school.education_level_name,
        is_custom_level: school.is_custom_level,
        npsn: school.npsn || '',
        email: school.email || '',
        phone: school.phone || '',
        address: school.address || '',
        is_registration_open: school.is_registration_open,
        logo: null as File | null,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('admin.school.update'), {
            forceFormData: true,
        });
    };

    const handleFileSelect = (file: File) => {
        // Validate client-side
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, SVG, atau WebP.');
            return;
        }

        if (file.size > maxSize) {
            alert('Ukuran file maksimal 2MB.');
            return;
        }

        setData('logo', file);

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            setLogoPreview(e.target?.result as string);
        };
        reader.readAsDataURL(file);
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) handleFileSelect(file);
    };

    const handleDragOver = (e: React.DragEvent) => {
        e.preventDefault();
        setIsDragging(true);
    };

    const handleDragLeave = (e: React.DragEvent) => {
        e.preventDefault();
        setIsDragging(false);
    };

    const handleDrop = (e: React.DragEvent) => {
        e.preventDefault();
        setIsDragging(false);
        const file = e.dataTransfer.files?.[0];
        if (file) handleFileSelect(file);
    };

    const handleDeleteLogo = () => {
        if (!confirm('Yakin ingin menghapus logo sekolah?')) return;
        setDeletingLogo(true);
        router.delete(route('admin.school.logo.destroy'), {
            onFinish: () => {
                setDeletingLogo(false);
                setLogoPreview(null);
            },
        });
    };

    const handleClearPreview = () => {
        setData('logo', null);
        setLogoPreview(null);
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const displayLogo = logoPreview || school.logo_url;

    return (
        <AdminLayout>
            <Head title="Pengaturan Sekolah" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-2xl font-bold tracking-tight text-slate-900">Pengaturan Sekolah</h2>
                        <p className="text-slate-500 text-sm">Kelola profil instansi dan konfigurasi pendaftaran.</p>
                    </div>
                </div>

                <form onSubmit={handleSubmit} className="grid gap-6 lg:grid-cols-3">
                    <div className="lg:col-span-2 space-y-6">
                        {/* Logo Upload Card */}
                        <Card className="border-none shadow-sm overflow-hidden">
                            <CardHeader className="bg-white border-b border-slate-100 pb-4">
                                <div className="flex items-center gap-2">
                                    <ImageIcon className="h-5 w-5 text-indigo-500" />
                                    <CardTitle className="text-base font-semibold">Logo Sekolah</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent className="p-6">
                                <div className="flex flex-col sm:flex-row items-start gap-6">
                                    {/* Logo Preview */}
                                    <div className="shrink-0">
                                        <div className={cn(
                                            "h-28 w-28 rounded-2xl border-2 border-dashed flex items-center justify-center overflow-hidden transition-all",
                                            displayLogo 
                                                ? "border-indigo-200 bg-white shadow-sm" 
                                                : "border-slate-200 bg-slate-50"
                                        )}>
                                            {displayLogo ? (
                                                <img
                                                    src={displayLogo}
                                                    alt="Logo sekolah"
                                                    className="h-full w-full object-contain p-2"
                                                />
                                            ) : (
                                                <div className="text-center">
                                                    <School className="h-10 w-10 text-slate-300 mx-auto" />
                                                    <p className="text-[10px] text-slate-400 mt-1">No Logo</p>
                                                </div>
                                            )}
                                        </div>
                                    </div>

                                    {/* Upload Area */}
                                    <div className="flex-1 w-full space-y-3">
                                        <div
                                            onDragOver={handleDragOver}
                                            onDragLeave={handleDragLeave}
                                            onDrop={handleDrop}
                                            onClick={() => fileInputRef.current?.click()}
                                            className={cn(
                                                "border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-all",
                                                isDragging
                                                    ? "border-indigo-400 bg-indigo-50/50 scale-[1.02]"
                                                    : "border-slate-200 bg-slate-50/50 hover:border-indigo-300 hover:bg-indigo-50/30"
                                            )}
                                        >
                                            <input
                                                ref={fileInputRef}
                                                type="file"
                                                accept="image/jpeg,image/jpg,image/png,image/svg+xml,image/webp"
                                                onChange={handleFileChange}
                                                className="hidden"
                                            />
                                            <Upload className={cn(
                                                "h-8 w-8 mx-auto mb-2 transition-colors",
                                                isDragging ? "text-indigo-500" : "text-slate-400"
                                            )} />
                                            <p className="text-sm font-medium text-slate-600">
                                                {isDragging ? 'Lepaskan file di sini...' : 'Klik atau drag & drop logo di sini'}
                                            </p>
                                            <p className="text-xs text-slate-400 mt-1">
                                                JPG, PNG, SVG, WebP • Maks 2MB
                                            </p>
                                        </div>

                                        {errors.logo && (
                                            <p className="text-xs text-red-500 font-medium">{errors.logo}</p>
                                        )}

                                        {/* Action Buttons */}
                                        <div className="flex items-center gap-2">
                                            {logoPreview && (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    size="sm"
                                                    onClick={handleClearPreview}
                                                    className="text-slate-600 text-xs"
                                                >
                                                    Batal Pilih
                                                </Button>
                                            )}
                                            {school.logo_url && !logoPreview && (
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    size="sm"
                                                    onClick={handleDeleteLogo}
                                                    disabled={deletingLogo}
                                                    className="text-red-500 hover:text-red-600 hover:bg-red-50 border-red-200 text-xs"
                                                >
                                                    {deletingLogo ? (
                                                        <Loader2 className="h-3 w-3 mr-1.5 animate-spin" />
                                                    ) : (
                                                        <Trash2 className="h-3 w-3 mr-1.5" />
                                                    )}
                                                    Hapus Logo
                                                </Button>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Identity & Contact Card */}
                        <Card className="border-none shadow-sm overflow-hidden">
                            <CardHeader className="bg-white border-b border-slate-100 pb-4">
                                <div className="flex items-center gap-2">
                                    <School className="h-5 w-5 text-indigo-500" />
                                    <CardTitle className="text-base font-semibold">Identitas &amp; Kontak</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent className="p-6 space-y-6">
                                <div className="grid gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="name" className="text-slate-700">Nama Sekolah</Label>
                                        <Input
                                            id="name"
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            required
                                            className={cn("h-11", errors.name && "border-red-500")}
                                        />
                                        {errors.name && <p className="text-xs text-red-500 font-medium">{errors.name}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="slug" className="text-slate-700">Slug / URL (Tanpa Spasi)</Label>
                                        <div className="flex items-center">
                                            <div className="h-11 px-3 flex items-center bg-slate-50 border border-r-0 border-slate-200 rounded-l-md text-xs text-slate-400">
                                                ppdb.pro/
                                            </div>
                                            <Input
                                                id="slug"
                                                value={data.slug}
                                                onChange={(e) => setData('slug', e.target.value)}
                                                required
                                                className={cn("h-11 rounded-l-none", errors.slug && "border-red-500")}
                                            />
                                        </div>
                                        {errors.slug && <p className="text-xs text-red-500 font-medium">{errors.slug}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="npsn" className="text-slate-700">NPSN</Label>
                                        <Input
                                            id="npsn"
                                            value={data.npsn}
                                            onChange={(e) => setData('npsn', e.target.value)}
                                            className={cn("h-11", errors.npsn && "border-red-500")}
                                        />
                                        {errors.npsn && <p className="text-xs text-red-500 font-medium">{errors.npsn}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="education_level_name" className="text-slate-700">Jenjang Pendidikan</Label>
                                        <Input
                                            id="education_level_name"
                                            value={data.education_level_name}
                                            onChange={(e) => setData('education_level_name', e.target.value)}
                                            placeholder="Contoh: SMA, SMP, SMK"
                                            className={cn("h-11", errors.education_level_name && "border-red-500")}
                                        />
                                        {errors.education_level_name && <p className="text-xs text-red-500 font-medium">{errors.education_level_name}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="email" className="text-slate-700">Email Instansi</Label>
                                        <Input
                                            id="email"
                                            type="email"
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            className={cn("h-11", errors.email && "border-red-500")}
                                        />
                                        {errors.email && <p className="text-xs text-red-500 font-medium">{errors.email}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="phone" className="text-slate-700">No. Telepon / WhatsApp</Label>
                                        <Input
                                            id="phone"
                                            value={data.phone}
                                            onChange={(e) => setData('phone', e.target.value)}
                                            className={cn("h-11", errors.phone && "border-red-500")}
                                        />
                                        {errors.phone && <p className="text-xs text-red-500 font-medium">{errors.phone}</p>}
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="address" className="text-slate-700">Alamat Lengkap</Label>
                                    <Textarea
                                        id="address"
                                        rows={4}
                                        value={data.address}
                                        onChange={(e) => setData('address', e.target.value)}
                                        className={cn("resize-none", errors.address && "border-red-500")}
                                    />
                                    {errors.address && <p className="text-xs text-red-500 font-medium">{errors.address}</p>}
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <div className="space-y-6">
                        {/* Registration Toggle */}
                        <Card className="border-none shadow-sm bg-indigo-600 text-white overflow-hidden">
                            <CardHeader className="pb-4">
                                <div className="flex items-center gap-2">
                                    <Settings2 className="h-5 w-5 text-indigo-200" />
                                    <CardTitle className="text-base font-semibold">Status Pendaftaran</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <p className="text-sm text-indigo-100 leading-relaxed">
                                    Kontrol akses publik pendaftaran. Jika dinonaktifkan, calon siswa tidak dapat mengirim formulir.
                                </p>
                                <div className="flex items-center justify-between p-4 bg-white/10 rounded-xl border border-white/10">
                                    <span className="font-bold">Buka Pendaftaran</span>
                                    <Switch
                                        checked={data.is_registration_open}
                                        onCheckedChange={(checked: boolean) => setData('is_registration_open', checked)}
                                        className="data-[state=checked]:bg-indigo-400"
                                    />
                                </div>
                            </CardContent>
                        </Card>

                        {/* Save Card */}
                        <Card className="border-none shadow-sm overflow-hidden sticky top-24">
                            <CardContent className="p-6">
                                <Button 
                                    type="submit" 
                                    className="w-full h-11 bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-lg shadow-indigo-100"
                                    disabled={processing}
                                >
                                    {processing ? (
                                        <Loader2 className="h-4 w-4 mr-2 animate-spin" />
                                    ) : (
                                        <Save className="h-4 w-4 mr-2" />
                                    )}
                                    {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                                </Button>
                                
                                {recentlySuccessful && (
                                    <div className="mt-4 flex items-center justify-center gap-2 text-emerald-600 bg-emerald-50 py-2 rounded-lg border border-emerald-100 animate-in fade-in slide-in-from-top-1">
                                        <CheckCircle2 className="h-4 w-4" />
                                        <span className="text-xs font-bold uppercase tracking-wider">Berhasil Disimpan</span>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
