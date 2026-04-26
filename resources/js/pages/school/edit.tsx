import { Head, Link, useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

type SchoolForm = {
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
  is_registration_open: boolean;
};

type Props = {
  school: SchoolForm;
};

export default function EditSchoolPage({ school }: Props) {
  const { data, setData, put, processing, errors } = useForm({
    name: school.name ?? '',
    slug: school.slug ?? '',
    education_level_code: school.education_level_code ?? '',
    education_level_name: school.education_level_name ?? '',
    is_custom_level: school.is_custom_level ?? false,
    npsn: school.npsn ?? '',
    email: school.email ?? '',
    phone: school.phone ?? '',
    address: school.address ?? '',
    is_registration_open: school.is_registration_open ?? false,
  });

  const submit = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    put('/admin/school');
  };

  return (
    <>
      <Head title="Profil Sekolah" />

      <div className="min-h-screen bg-slate-50">
        <header className="border-b bg-white">
          <div className="mx-auto flex max-w-4xl items-center justify-between px-6 py-4">
            <div>
              <h1 className="text-2xl font-bold text-slate-900">
                Profil Sekolah
              </h1>
              <p className="text-sm text-slate-600">
                Atur identitas sekolah untuk PPDB Pro
              </p>
            </div>

            <Link
              href="/admin/dashboard"
              className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
            >
              Kembali
            </Link>
          </div>
        </header>

        <main className="mx-auto max-w-4xl px-6 py-8">
          <form
            onSubmit={submit}
            className="rounded-2xl border bg-white p-6 shadow-sm"
          >
            <div className="grid gap-6 md:grid-cols-2">
              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Nama Sekolah
                </label>
                <input
                  type="text"
                  value={data.name}
                  onChange={(e) =>
                    setData('name', e.target.value)
                  }
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.name && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.name}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Slug
                </label>
                <input
                  type="text"
                  value={data.slug}
                  onChange={(e) =>
                    setData('slug', e.target.value)
                  }
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.slug && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.slug}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Kode Jenjang
                </label>
                <input
                  type="text"
                  value={data.education_level_code}
                  onChange={(e) =>
                    setData(
                      'education_level_code',
                      e.target.value,
                    )
                  }
                  placeholder="Contoh: TK, SD, SMP, SMA, SMK"
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.education_level_code && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.education_level_code}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Nama Jenjang
                </label>
                <input
                  type="text"
                  value={data.education_level_name}
                  onChange={(e) =>
                    setData(
                      'education_level_name',
                      e.target.value,
                    )
                  }
                  placeholder="Contoh: Sekolah Menengah Kejuruan"
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.education_level_name && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.education_level_name}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  NPSN
                </label>
                <input
                  type="text"
                  value={data.npsn}
                  onChange={(e) =>
                    setData('npsn', e.target.value)
                  }
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.npsn && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.npsn}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Email Sekolah
                </label>
                <input
                  type="email"
                  value={data.email}
                  onChange={(e) =>
                    setData('email', e.target.value)
                  }
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.email && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.email}
                  </p>
                )}
              </div>

              <div>
                <label className="mb-2 block text-sm font-medium text-slate-700">
                  Telepon
                </label>
                <input
                  type="text"
                  value={data.phone}
                  onChange={(e) =>
                    setData('phone', e.target.value)
                  }
                  className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
                />
                {errors.phone && (
                  <p className="mt-2 text-sm text-rose-600">
                    {errors.phone}
                  </p>
                )}
              </div>

              <div className="flex items-center gap-3 pt-8">
                <input
                  id="is_custom_level"
                  type="checkbox"
                  checked={data.is_custom_level}
                  onChange={(e) =>
                    setData(
                      'is_custom_level',
                      e.target.checked,
                    )
                  }
                  className="h-4 w-4 rounded border-slate-300"
                />
                <label
                  htmlFor="is_custom_level"
                  className="text-sm font-medium text-slate-700"
                >
                  Jenjang custom
                </label>
              </div>
            </div>

            <div className="mt-6">
              <label className="mb-2 block text-sm font-medium text-slate-700">
                Alamat
              </label>
              <textarea
                value={data.address}
                onChange={(e) =>
                  setData('address', e.target.value)
                }
                rows={4}
                className="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-900 focus:outline-none"
              />
              {errors.address && (
                <p className="mt-2 text-sm text-rose-600">
                  {errors.address}
                </p>
              )}
            </div>

            <div className="mt-6 flex items-center gap-3">
              <input
                id="is_registration_open"
                type="checkbox"
                checked={data.is_registration_open}
                onChange={(e) =>
                  setData(
                    'is_registration_open',
                    e.target.checked,
                  )
                }
                className="h-4 w-4 rounded border-slate-300"
              />
              <label
                htmlFor="is_registration_open"
                className="text-sm font-medium text-slate-700"
              >
                Buka pendaftaran PPDB
              </label>
            </div>

            <div className="mt-8 flex items-center gap-3">
              <button
                type="submit"
                disabled={processing}
                className="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 disabled:opacity-50"
              >
                {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
              </button>

              <Link
                href="/admin/dashboard"
                className="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100"
              >
                Batal
              </Link>
            </div>
          </form>
        </main>
      </div>
    </>
  );
}