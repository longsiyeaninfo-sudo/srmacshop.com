<x-filament-panels::page>
    @push('styles')
        <style>
        .iu-wrap{max-width:560px;margin:0 auto;display:flex;flex-direction:column;gap:18px}
        .iu-card{background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .dark .iu-card{background:#2c2c2e;border-color:rgba(255,255,255,.08)}
        .iu-title{font-size:18px;font-weight:700;margin:0 0 4px;letter-spacing:-.014em;color:#1d1d1f}
        .dark .iu-title{color:#f5f5f7}
        .iu-sub{font-size:13px;color:#6e6e73;margin:0 0 18px}
        .iu-field{margin-bottom:14px}
        .iu-field label{display:block;font-size:13px;font-weight:600;color:#1d1d1f;margin-bottom:6px}
        .dark .iu-field label{color:#f5f5f7}
        .iu-input{width:100%;padding:9px 13px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;background:#fff;color:#1d1d1f;outline:none;transition:all .15s cubic-bezier(.4,0,.2,1);font-family:inherit}
        .dark .iu-input{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14);color:#f5f5f7}
        .iu-input:focus{border-color:#007aff;box-shadow:0 0 0 4px rgba(0,122,255,.18)}
        .iu-radio-row{display:grid;grid-template-columns:1fr 1fr;gap:8px}
        .iu-radio{padding:14px 12px;border:1.5px solid #d2d2d7;border-radius:10px;background:#fff;cursor:pointer;text-align:center;transition:all .15s cubic-bezier(.4,0,.2,1)}
        .dark .iu-radio{background:rgba(255,255,255,.04);border-color:rgba(255,255,255,.14)}
        .iu-radio.on{border-color:#007aff;background:#eff6ff;color:#1d4ed8}
        .dark .iu-radio.on{background:rgba(0,122,255,.15);color:#7eb6ff}
        .iu-radio-title{font-weight:700;font-size:14px;margin-bottom:2px}
        .iu-radio-desc{font-size:11.5px;color:#6e6e73}
        .iu-radio.on .iu-radio-desc{color:#1d4ed8}
        .iu-btn{width:100%;padding:11px;border:0;border-radius:9px;font-size:14px;font-weight:700;cursor:pointer;color:#fff;background:linear-gradient(180deg,#0a84ff,#006fe6);box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 1px 2px rgba(0,122,255,.25);transition:all .12s cubic-bezier(.4,0,.2,1);font-family:inherit}
        .iu-btn:hover{box-shadow:inset 0 1px 0 rgba(255,255,255,.2),0 4px 10px rgba(0,122,255,.35)}
        .iu-err{font-size:12px;color:#ff3b30;margin-top:4px}

        .iu-pw-card{background:linear-gradient(135deg,#fff7ed,#fef3c7);border:1px solid #fed7aa;border-radius:14px;padding:22px}
        .iu-pw-badge{display:inline-block;padding:3px 10px;background:#16a34a;color:#fff;border-radius:980px;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:10px}
        .iu-pw-title{font-size:18px;font-weight:700;margin:0 0 4px;color:#1d1d1f}
        .iu-pw-sub{font-size:13px;color:#6e6e73;margin:0 0 14px;line-height:1.5}
        .iu-pw-box{display:flex;align-items:center;gap:10px;background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:10px;padding:12px 14px;font-family:ui-monospace,'SF Mono',Consolas,monospace;font-size:15px;font-weight:600;color:#1d1d1f}
        .iu-pw-copy{margin-left:auto;padding:6px 14px;border:0;border-radius:7px;background:#007aff;color:#fff;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit}
        .iu-pw-copy:hover{background:#006fe6}
        .iu-pw-copy.copied{background:#34c759}
        .iu-pw-warn{font-size:12px;color:#92400e;margin-top:12px;padding:8px 12px;background:rgba(245,158,11,.1);border-radius:8px}
        .iu-pw-actions{display:flex;gap:8px;margin-top:14px}
        .iu-pw-actions a,.iu-pw-actions button{flex:1;text-align:center;padding:10px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer;border:0;font-family:inherit}
        .iu-pw-act-primary{background:#007aff;color:#fff}
        .iu-pw-act-ghost{background:rgba(0,0,0,.06);color:#1d1d1f}
        </style>
    @endpush

    <div class="iu-wrap">
        @if($generatedPassword)
            {{-- After-invite: show the generated password --}}
            <div class="iu-pw-card">
                <span class="iu-pw-badge">✓ Invited</span>
                <h2 class="iu-pw-title">{{ $name }} can now sign in</h2>
                <p class="iu-pw-sub">Share this temporary password with <strong>{{ $email }}</strong>. They should change it after their first login.</p>
                <div class="iu-pw-box" x-data="{copied:false}">
                    <span x-ref="pw">{{ $generatedPassword }}</span>
                    <button type="button"
                        @click="navigator.clipboard.writeText($refs.pw.textContent); copied=true; setTimeout(()=>copied=false, 1800)"
                        class="iu-pw-copy"
                        :class="copied ? 'copied' : ''"
                        x-text="copied ? '✓ Copied' : 'Copy'"></button>
                </div>
                <div class="iu-pw-warn">⚠️ This password is shown only once. Save it now — we don't store it in plain text.</div>
                <div class="iu-pw-actions">
                    <button type="button" wire:click="reset_form" class="iu-pw-act-ghost">Invite another</button>
                    <a href="{{ \App\Filament\Admin\Resources\UserResource::getUrl('index') }}" class="iu-pw-act-primary">Back to Users</a>
                </div>
            </div>
        @else
            {{-- Invite form --}}
            <form wire:submit.prevent="submit">
                <div class="iu-card">
                    <h2 class="iu-title">Invite a teammate</h2>
                    <p class="iu-sub">They'll get a one-time password to sign in to the admin panel.</p>

                    <div class="iu-field">
                        <label>Full name</label>
                        <input type="text" wire:model.blur="name" class="iu-input" placeholder="e.g. Sokha Lim">
                        @error('name') <div class="iu-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="iu-field">
                        <label>Email</label>
                        <input type="email" wire:model.blur="email" class="iu-input" placeholder="colleague@example.com">
                        @error('email') <div class="iu-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="iu-field">
                        <label>Role</label>
                        <div class="iu-radio-row">
                            <div wire:click="$set('role', 'staff')" class="iu-radio {{ $role === 'staff' ? 'on' : '' }}">
                                <div class="iu-radio-title">Staff</div>
                                <div class="iu-radio-desc">Manage orders & products</div>
                            </div>
                            <div wire:click="$set('role', 'admin')" class="iu-radio {{ $role === 'admin' ? 'on' : '' }}">
                                <div class="iu-radio-title">Admin</div>
                                <div class="iu-radio-desc">Full access, including settings</div>
                            </div>
                        </div>
                        @error('role') <div class="iu-err">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="iu-btn"
                        wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Create account & generate password</span>
                        <span wire:loading wire:target="submit">Creating…</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-filament-panels::page>
