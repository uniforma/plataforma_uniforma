import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.tagInput = (initial = [], options = []) => ({
    tags: Array.isArray(initial) ? initial.map(value => value.trim().replace(/\s+/g, ' ').toLocaleUpperCase('pt-BR')) : [],
    options: Array.isArray(options) ? options : [],
    entry: '',
    open: false,
    normalize(value) { return value.trimStart().replace(/\s+/g, ' ').toLocaleUpperCase('pt-BR'); },
    get available() {
        const query = this.normalize(this.entry);
        return this.options.filter(option => !this.tags.includes(option) && (!query || option.includes(query))).slice(0, 8);
    },
    select(value) {
        if (this.tags.length < 20 && !this.tags.includes(value)) this.tags.push(value);
        this.entry = '';
        this.open = false;
    },
    add() {
        const value = this.normalize(this.entry).trim();
        if (value && value.length <= 80 && this.tags.length < 20 && !this.tags.includes(value)) {
            this.tags.push(value);
            if (!this.options.includes(value)) this.options.push(value);
        }
        this.entry = '';
        this.open = false;
    },
    remove(value) { this.tags = this.tags.filter(tag => tag !== value); },
});

window.normalizeCatalogInput = (input) => {
    input.value = input.value.trimStart().replace(/\s+/g, ' ').toLocaleUpperCase('pt-BR');
};

window.accessibilityControls = () => {
    let saved = {};
    try { saved = JSON.parse(localStorage.getItem('uniforma.accessibility') || '{}'); } catch (_) {}

    return {
        scale: [100, 110, 120, 130, 140, 150].includes(Number(saved.scale)) ? Number(saved.scale) : 100,
        contrast: saved.contrast === true,
        announcement: '',
        apply() {
            document.documentElement.style.fontSize = `${this.scale}%`;
            document.documentElement.dataset.contrast = this.contrast ? 'high' : 'normal';
            try { localStorage.setItem('uniforma.accessibility', JSON.stringify({ scale: this.scale, contrast: this.contrast })); } catch (_) {}
            this.announcement = `Fonte em ${this.scale} por cento. Alto contraste ${this.contrast ? 'ativado' : 'desativado'}.`;
        },
        increase() { this.scale = Math.min(150, this.scale + 10); this.apply(); },
        decrease() { this.scale = Math.max(100, this.scale - 10); this.apply(); },
        toggleContrast() { this.contrast = !this.contrast; this.apply(); },
    };
};

Alpine.start();

// A máscara é apenas visual; a validação definitiva ocorre no servidor.
const formatCpf = (value) => {
    const digits = value.replace(/\D/g, '').slice(0, 11);
    return digits.replace(/^(\d{3})(\d)/, '$1.$2')
        .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
};

document.querySelectorAll('input[data-cpf]').forEach((input) => {
    input.value = formatCpf(input.value);
    input.addEventListener('input', () => { input.value = formatCpf(input.value); });
});
