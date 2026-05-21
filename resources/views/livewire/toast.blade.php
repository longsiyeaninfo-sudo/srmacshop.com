<div id="toastWrap" class="toast"
    x-data="{ items: [] }"
    x-on:toast.window="
        const t = $event.detail;
        const item = { id: Date.now(), message: t.message, type: t.type || 'blue' };
        items.push(item);
        $el.style.display = 'flex';
        setTimeout(() => {
            items = items.filter(i => i.id !== item.id);
            if (!items.length) $el.style.display = 'none';
        }, 2800);
    "
    style="display:none">
    <template x-for="item in items" :key="item.id">
        <div class="toast-item"
            :style="'border-left-color:' + (item.type==='success'||item.type==='green' ? 'var(--green)' : item.type==='error'||item.type==='red' ? 'var(--red)' : 'var(--blue)')"
            x-text="item.message"></div>
    </template>
</div>
