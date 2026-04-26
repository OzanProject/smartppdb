import React, { useState, useEffect } from 'react';
import { Link, usePage, router } from '@inertiajs/react';
import { 
    LayoutDashboard, 
    Users, 
    Settings, 
    LogOut, 
    Menu, 
    X, 
    ChevronDown,
    School,
    ClipboardList,
    Calendar,
    GraduationCap,
} from 'lucide-react';
import { Button } from '@/Components/ui/button';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuLabel, 
    DropdownMenuSeparator, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { cn } from '@/lib/utils';

interface AdminLayoutProps {
    children: React.ReactNode;
}

export default function AdminLayout({ children }: AdminLayoutProps) {
    const { auth, school } = usePage().props as any;
    const [isSidebarOpen, setIsSidebarOpen] = useState(true);
    const [isMobile, setIsMobile] = useState(false);

    useEffect(() => {
        const checkMobile = () => {
            const mobile = window.innerWidth < 1024;
            setIsMobile(mobile);
            if (mobile) {
                setIsSidebarOpen(false);
            } else {
                setIsSidebarOpen(true);
            }
        };

        checkMobile();
        window.addEventListener('resize', checkMobile);
        
        const unbind = router.on('navigate', () => {
            if (window.innerWidth < 1024) {
                setIsSidebarOpen(false);
            }
        });

        return () => {
            window.removeEventListener('resize', checkMobile);
            unbind();
        };
    }, []);

    const navigation = [
        { name: 'Dashboard', href: route('admin.dashboard'), icon: LayoutDashboard, active: route().current('admin.dashboard') },
        { name: 'Tahun Ajaran', href: route('admin.academic-years.index'), icon: Calendar, active: route().current('admin.academic-years.*') },
        { name: 'Gelombang', href: route('admin.batches.index'), icon: GraduationCap, active: route().current('admin.batches.*') },
        { name: 'Pendaftar', href: route('admin.registrations.index'), icon: ClipboardList, active: route().current('admin.registrations.*') },
        { name: 'Data Siswa', href: route('admin.students.index'), icon: Users, active: route().current('admin.students.*') },
        { name: 'Pengaturan', href: route('admin.school.edit'), icon: Settings, active: route().current('admin.school.*') },
    ];

    const schoolName = school?.name || 'PPDB PRO';
    const schoolLogoUrl = school?.logo_url;

    return (
        <div className="flex h-screen bg-slate-50 overflow-hidden font-sans antialiased text-slate-900">
            {/* Mobile Backdrop */}
            {isMobile && isSidebarOpen && (
                <div 
                    className="fixed inset-0 bg-slate-900/60 z-[60] backdrop-blur-sm transition-opacity duration-300"
                    onClick={() => setIsSidebarOpen(false)}
                />
            )}

            {/* Sidebar Container */}
            <aside 
                className={cn(
                    "bg-slate-900 text-slate-300 flex flex-col transition-all duration-300 ease-in-out z-[70]",
                    isMobile 
                        ? "fixed inset-y-0 left-0 w-64 transform" 
                        : "relative w-64 shrink-0",
                    isMobile && !isSidebarOpen ? "-translate-x-full" : "translate-x-0",
                    !isMobile && !isSidebarOpen ? "w-0 overflow-hidden" : ""
                )}
            >
                <div className="flex h-16 shrink-0 items-center justify-between px-4 border-b border-white/10">
                    <Link href={route('admin.dashboard')} className="flex items-center gap-2.5 min-w-0">
                        {schoolLogoUrl ? (
                            <img 
                                src={schoolLogoUrl} 
                                alt={schoolName}
                                className="h-9 w-9 rounded-xl object-contain bg-white/10 p-0.5 shrink-0"
                            />
                        ) : (
                            <div className="h-9 w-9 rounded-xl bg-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 shrink-0">
                                <School className="h-5 w-5 text-white" />
                            </div>
                        )}
                        <span className="font-bold text-white tracking-tight truncate text-sm">
                            {schoolName}
                        </span>
                    </Link>
                </div>

                <nav className="flex-1 overflow-y-auto p-4 space-y-1 relative z-10">
                    {navigation.map((item) => (
                        <Link
                            key={item.name}
                            href={item.href}
                            className={cn(
                                "flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group relative z-20",
                                item.active 
                                    ? "bg-indigo-600 text-white shadow-lg shadow-indigo-600/20" 
                                    : "hover:bg-white/5 hover:text-white text-slate-400"
                            )}
                        >
                            <item.icon className={cn("h-4 w-4 shrink-0", item.active ? "text-white" : "group-hover:text-indigo-400")} />
                            <span className="truncate">{item.name}</span>
                        </Link>
                    ))}
                </nav>

                <div className="p-4 border-t border-white/10 shrink-0">
                    <div className="bg-white/5 rounded-2xl p-3 flex items-center gap-3">
                        <div className="h-9 w-9 rounded-xl bg-slate-700 flex items-center justify-center text-xs font-bold text-white uppercase shrink-0">
                            {auth.user.name.charAt(0)}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-xs font-bold text-white truncate">{auth.user.name}</p>
                            <p className="text-[10px] text-slate-400 uppercase tracking-wider">Administrator</p>
                        </div>
                    </div>
                </div>
            </aside>

            {/* Main Content Area */}
            <div className="flex-1 flex flex-col min-w-0 relative z-0">
                <header className="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0 z-30">
                    <div className="flex items-center gap-4">
                        <button 
                            onClick={() => setIsSidebarOpen(!isSidebarOpen)} 
                            className="p-2 -ml-2 text-slate-500 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-all cursor-pointer"
                        >
                            <Menu className="h-5 w-5" />
                        </button>
                        <span className="text-sm font-medium text-slate-500 hidden sm:block">
                            Sistem PPDB — {schoolName}
                        </span>
                    </div>

                    <div className="flex items-center gap-3">
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" className="flex items-center gap-2 pl-2 pr-1.5 hover:bg-slate-100 h-10 rounded-xl border border-transparent hover:border-slate-200">
                                    <div className="h-7 w-7 rounded-lg bg-indigo-500 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                        {auth.user.name.charAt(0)}
                                    </div>
                                    <ChevronDown className="h-3 w-3 text-slate-400" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" className="w-56 mt-2">
                                <DropdownMenuLabel>Akun Admin</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem asChild>
                                    <Link href={route('profile.edit')} className="w-full cursor-pointer">Profil Akun</Link>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem asChild className="text-red-500">
                                    <Link href={route('logout')} method="post" as="button" className="flex items-center gap-2 w-full text-left cursor-pointer">
                                        <LogOut className="h-4 w-4" /> Keluar
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </header>

                <main className="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-8">
                    <div className="max-w-7xl mx-auto w-full">
                        {children}
                    </div>
                </main>
            </div>
        </div>
    );
}
