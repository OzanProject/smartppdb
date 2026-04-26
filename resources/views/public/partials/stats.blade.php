<?php
/********************************************************************************
 * stats.blade.php
 * Statistics partial for the landing page.
 * Content is dynamic and configurable via the Super Admin panel.
 ********************************************************************************/
?>
<section id="stats" class="py-24 bg-indigo-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-white rounded-[3rem] p-12 shadow-soft relative overflow-hidden border border-slate-100">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <span class="material-symbols-outlined text-[120px] text-indigo-600">analytics</span>
            </div>
            
            <div class="grid lg:grid-cols-4 gap-12 items-center relative z-10">
                <div class="lg:col-span-1">
                    <h3 class="text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $settings['stats_title'] ?? 'Dipercaya oleh 500+ sekolah di Indonesia' }}
                    </h3>
                </div>
                
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center md:text-left">
                        <div class="text-5xl font-black text-indigo-600 mb-2">
                            {{ $settings['stats_schools'] ?? '500+' }}
                        </div>
                        <div class="text-slate-500 font-semibold uppercase tracking-wider text-sm">Sekolah Aktif</div>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <div class="text-5xl font-black text-indigo-600 mb-2">
                            {{ $settings['stats_applicants'] ?? '50k+' }}
                        </div>
                        <div class="text-slate-500 font-semibold uppercase tracking-wider text-sm">Pendaftar Pertahun</div>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <div class="text-5xl font-black text-indigo-600 mb-2">
                            {{ $settings['stats_uptime'] ?? '99.9%' }}
                        </div>
                        <div class="text-slate-500 font-semibold uppercase tracking-wider text-sm">System Uptime</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
