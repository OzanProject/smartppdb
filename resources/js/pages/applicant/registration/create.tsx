import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Button } from '@/Components/ui/button';
import { useState, FormEventHandler } from 'react';
import { ChevronRight, ChevronLeft, Save, User as UserIcon, Users as UsersIcon, School as SchoolIcon, CheckCircle2 } from 'lucide-react';

type SchoolProps = {
    id: number;
    name: string;
};

type BatchProps = {
    id: number;
    name: string;
};

type Props = {
    school: SchoolProps;
    batch: BatchProps;
};

export default function Create({ school, batch }: Props) {
    const [step, setStep] = useState(1);
    
    const { data, setData, post, processing, errors } = useForm({
        school_id: school.id,
        admission_batch_id: batch.id,
        // Step 1: Personal Data
        personal_data: {
            full_name: '',
            nickname: '',
            gender: '',
            birth_place: '',
            birth_date: '',
            religion: '',
            address: '',
        },
        // Step 2: Parent Data
        parent_data: {
            father_name: '',
            father_occupation: '',
            mother_name: '',
            mother_occupation: '',
            parent_phone: '',
        },
        // Step 3: Previous School Data
        previous_school_data: {
            school_name: '',
            school_city: '',
            graduation_year: '',
            un_number: '',
        }
    });

    const nextStep = () => setStep(step + 1);
    const prevStep = () => setStep(step - 1);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('applicant.registration.store'));
    };

    const steps = [
        { id: 1, title: 'Biodata Diri', icon: UserIcon },
        { id: 2, title: 'Data Orang Tua', icon: UsersIcon },
        { id: 3, title: 'Asal Sekolah', icon: SchoolIcon },
        { id: 4, title: 'Konfirmasi', icon: CheckCircle2 },
    ];

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Formulir Pendaftaran</h2>}
        >
            <Head title="Pendaftaran Baru" />

            <div className="py-12">
                <div className="mx-auto max-w-4xl sm:px-6 lg:px-8">
                    
                    {/* Stepper */}
                    <div className="mb-8 px-4">
                        <div className="flex items-center justify-between relative">
                            <div className="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-200 -z-10 transform -translate-y-1/2" />
                            {steps.map((s) => (
                                <div key={s.id} className="flex flex-col items-center">
                                    <div className={`w-10 h-10 rounded-full flex items-center justify-center border-2 bg-white transition-all duration-300 ${step >= s.id ? 'border-indigo-600 text-indigo-600 ring-4 ring-indigo-50' : 'border-slate-300 text-slate-400'}`}>
                                        <s.icon className="h-5 w-5" />
                                    </div>
                                    <span className={`mt-2 text-xs font-medium hidden sm:block ${step >= s.id ? 'text-indigo-600' : 'text-slate-400'}`}>
                                        {s.title}
                                    </span>
                                </div>
                            ))}
                        </div>
                    </div>

                    <form onSubmit={submit}>
                        {/* Step 1: Personal Data */}
                        {step === 1 && (
                            <Card className="border-none shadow-sm animate-in fade-in slide-in-from-bottom-4 duration-500">
                                <CardHeader>
                                    <CardTitle>Biodata Calon Siswa</CardTitle>
                                    <CardDescription>Masukkan informasi identitas diri Anda sesuai akta kelahiran.</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="full_name">Nama Lengkap</Label>
                                        <Input 
                                            value={data.personal_data.full_name} 
                                            onChange={e => setData('personal_data', {...data.personal_data, full_name: e.target.value})} 
                                            placeholder="Sesuai Ijazah/Akta" 
                                        />
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="birth_place">Tempat Lahir</Label>
                                            <Input 
                                                value={data.personal_data.birth_place} 
                                                onChange={e => setData('personal_data', {...data.personal_data, birth_place: e.target.value})} 
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="birth_date">Tanggal Lahir</Label>
                                            <Input 
                                                type="date"
                                                value={data.personal_data.birth_date} 
                                                onChange={e => setData('personal_data', {...data.personal_data, birth_date: e.target.value})} 
                                            />
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="address">Alamat Domisili</Label>
                                        <Textarea 
                                            value={data.personal_data.address} 
                                            onChange={e => setData('personal_data', {...data.personal_data, address: e.target.value})} 
                                        />
                                    </div>
                                    <div className="flex justify-end pt-4">
                                        <Button type="button" onClick={nextStep} className="bg-indigo-600 hover:bg-indigo-500">
                                            Lanjut <ChevronRight className="ml-2 h-4 w-4" />
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Step 2: Parent Data */}
                        {step === 2 && (
                            <Card className="border-none shadow-sm animate-in fade-in slide-in-from-right-4 duration-500">
                                <CardHeader>
                                    <CardTitle>Data Orang Tua / Wali</CardTitle>
                                    <CardDescription>Informasi orang tua kandung atau wali murid.</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="father_name">Nama Ayah</Label>
                                            <Input 
                                                value={data.parent_data.father_name} 
                                                onChange={e => setData('parent_data', {...data.parent_data, father_name: e.target.value})} 
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="mother_name">Nama Ibu</Label>
                                            <Input 
                                                value={data.parent_data.mother_name} 
                                                onChange={e => setData('parent_data', {...data.parent_data, mother_name: e.target.value})} 
                                            />
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="parent_phone">No. HP Orang Tua (WhatsApp)</Label>
                                        <Input 
                                            value={data.parent_data.parent_phone} 
                                            onChange={e => setData('parent_data', {...data.parent_data, parent_phone: e.target.value})} 
                                            placeholder="0812xxxx"
                                        />
                                    </div>
                                    <div className="flex justify-between pt-4">
                                        <Button type="button" variant="outline" onClick={prevStep}>
                                            <ChevronLeft className="mr-2 h-4 w-4" /> Kembali
                                        </Button>
                                        <Button type="button" onClick={nextStep} className="bg-indigo-600 hover:bg-indigo-500">
                                            Lanjut <ChevronRight className="ml-2 h-4 w-4" />
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Step 3: School Data */}
                        {step === 3 && (
                            <Card className="border-none shadow-sm animate-in fade-in slide-in-from-right-4 duration-500">
                                <CardHeader>
                                    <CardTitle>Asal Sekolah</CardTitle>
                                    <CardDescription>Informasi mengenai sekolah asal sebelumnya.</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="school_name">Nama Sekolah Asal</Label>
                                        <Input 
                                            value={data.previous_school_data.school_name} 
                                            onChange={e => setData('previous_school_data', {...data.previous_school_data, school_name: e.target.value})} 
                                        />
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="graduation_year">Tahun Lulus</Label>
                                            <Input 
                                                value={data.previous_school_data.graduation_year} 
                                                onChange={e => setData('previous_school_data', {...data.previous_school_data, graduation_year: e.target.value})} 
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="un_number">Nomor Seri Ijazah/SKL</Label>
                                            <Input 
                                                value={data.previous_school_data.un_number} 
                                                onChange={e => setData('previous_school_data', {...data.previous_school_data, un_number: e.target.value})} 
                                            />
                                        </div>
                                    </div>
                                    <div className="flex justify-between pt-4">
                                        <Button type="button" variant="outline" onClick={prevStep}>
                                            <ChevronLeft className="mr-2 h-4 w-4" /> Kembali
                                        </Button>
                                        <Button type="button" onClick={nextStep} className="bg-indigo-600 hover:bg-indigo-500">
                                            Lanjut <ChevronRight className="ml-2 h-4 w-4" />
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Step 4: Confirmation */}
                        {step === 4 && (
                            <Card className="border-none shadow-sm animate-in fade-in zoom-in duration-500">
                                <CardHeader>
                                    <CardTitle>Konfirmasi Data</CardTitle>
                                    <CardDescription>Pastikan seluruh data yang Anda masukkan sudah benar sebelum dikirim.</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-6">
                                    <div className="rounded-lg bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800">
                                        <strong>Peringatan:</strong> Pastikan Nama, Tempat Tanggal Lahir, dan NPSN Sekolah Asal sesuai dengan dokumen asli.
                                    </div>
                                    
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div className="p-3 bg-slate-50 rounded-md">
                                            <p className="font-bold mb-1">Biodata Siswa</p>
                                            <p>{data.personal_data.full_name || '-'}</p>
                                            <p className="text-xs text-slate-500">{data.personal_data.birth_place}, {data.personal_data.birth_date}</p>
                                        </div>
                                        <div className="p-3 bg-slate-50 rounded-md">
                                            <p className="font-bold mb-1">Sekolah Asal</p>
                                            <p>{data.previous_school_data.school_name || '-'}</p>
                                            <p className="text-xs text-slate-500">Lulus Tahun: {data.previous_school_data.graduation_year}</p>
                                        </div>
                                    </div>

                                    <div className="flex justify-between pt-4">
                                        <Button type="button" variant="outline" onClick={prevStep}>
                                            <ChevronLeft className="mr-2 h-4 w-4" /> Kembali
                                        </Button>
                                        <Button type="submit" disabled={processing} className="bg-emerald-600 hover:bg-emerald-500">
                                            {processing ? 'Mengirim...' : 'Kirim Pendaftaran'} <Save className="ml-2 h-4 w-4" />
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        )}
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
