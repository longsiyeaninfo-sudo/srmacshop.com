<div
    x-data="{ items: [] }"
    x-on:toast.window="
        const item = { id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'info' };
       items.push(item);
        setTimeout(() => items = items.filter(i => i.id !== item.id), 3000);
    "
    style="position:fixed;bottom:24px;right:24px;z-index:80;display:flex;flex-direction:column;gap:8px"
>
    <template x-for="item in items" :key="item.id">
        <div :class="'toast toast-' + item.type"
       style="padding:12px 18px;background:#111;color:#fff;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.2)"
        x-text="item.message"></div>
    </template>
</div>
