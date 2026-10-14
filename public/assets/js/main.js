'use strict';

// ─── Mobile Menu ────────────────────────────────────────────────────────────
const menuBtn    = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

menuBtn?.addEventListener('click', () => {
  const isExpanded = menuBtn.getAttribute('aria-expanded') === 'true';
  menuBtn.setAttribute('aria-expanded', String(!isExpanded));
  mobileMenu.classList.toggle('hidden', isExpanded);
});

// Fecha menu ao clicar num link
mobileMenu?.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    menuBtn?.setAttribute('aria-expanded', 'false');
  });
});

// ─── Sticky header shadow ───────────────────────────────────────────────────
const header = document.getElementById('site-header');
window.addEventListener('scroll', () => {
  header?.classList.toggle('shadow-xl', window.scrollY > 10);
}, { passive: true });

// ─── FAQ Accordion ──────────────────────────────────────────────────────────
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const expanded = btn.getAttribute('aria-expanded') === 'true';

    // Fecha todos
    document.querySelectorAll('.faq-question').forEach(b => {
      b.setAttribute('aria-expanded', 'false');
      const panel = document.getElementById(b.getAttribute('aria-controls'));
      panel?.classList.add('hidden');
      b.querySelector('.faq-icon')?.classList.remove('rotate-180');
    });

    // Abre o clicado (se estava fechado)
    if (!expanded) {
      btn.setAttribute('aria-expanded', 'true');
      const panel = document.getElementById(btn.getAttribute('aria-controls'));
      panel?.classList.remove('hidden');
      btn.querySelector('.faq-icon')?.classList.add('rotate-180');
    }
  });
});

// ─── Plano → scroll até formulário ─────────────────────────────────────────
document.querySelectorAll('[data-plan]').forEach(btn => {
  btn.addEventListener('click', () => {
    const plan     = btn.dataset.plan;
    const planSel  = document.getElementById('plan');
    if (planSel) planSel.value = plan;
    document.getElementById('cadastro')?.scrollIntoView({ behavior: 'smooth' });
  });
});

// ─── Formulário ─────────────────────────────────────────────────────────────
const form = document.getElementById('lead-form');

form?.addEventListener('submit', async (e) => {
  e.preventDefault();

  const submitBtn  = form.querySelector('[data-submit-btn]');
  const btnText    = submitBtn.querySelector('[data-btn-text]');
  const btnSpinner = submitBtn.querySelector('[data-btn-spinner]');

  // Estado de carregamento
  submitBtn.disabled = true;
  btnText.textContent = 'Enviando…';
  btnSpinner.classList.remove('hidden');
  clearErrors();

  const ab = document.cookie.match(/devflow_ab=([AB])/)?.[1] ?? 'A';

  const payload = {
    name:              form.elements['name'].value.trim(),
    email:             form.elements['email'].value.trim(),
    user_type:         form.elements['user_type'].value,
    plan:              form.elements['plan'].value,
    contact_consent:   form.elements['contact_consent'].checked,
    marketing_consent: form.elements['marketing_consent']?.checked ?? false,
    ab_variant:        ab,
  };

  try {
    const res  = await fetch('/api/leads', {
      method:  'POST',
      headers: { 'Content-Type': 'application/json' },
      body:    JSON.stringify(payload),
    });

    const json = await res.json();

    if (json.success) {
      showSuccess();
    } else {
      if (json.errors && typeof json.errors === 'object') {
        showFieldErrors(json.errors);
      }
      showFormError(json.message || 'Ocorreu um erro. Tente novamente.');
    }
  } catch {
    showFormError('Erro de conexão. Verifique sua internet e tente novamente.');
  } finally {
    submitBtn.disabled = false;
    btnText.textContent = 'Cadastrar meu interesse';
    btnSpinner.classList.add('hidden');
  }
});

function clearErrors() {
  form?.querySelectorAll('.field-error').forEach(el => el.textContent = '');
  const formError = document.getElementById('form-error');
  if (formError) {
    formError.textContent = '';
    formError.classList.add('hidden');
  }
}

function showFieldErrors(errors) {
  Object.entries(errors).forEach(([field, message]) => {
    const id = 'error-' + field.replaceAll('_', '-');
    const el = document.getElementById(id);
    if (el) el.textContent = message;
  });
}

function showFormError(message) {
  const el = document.getElementById('form-error');
  if (el) {
    el.textContent = message;
    el.classList.remove('hidden');
  }
}

function showSuccess() {
  document.getElementById('lead-form')?.classList.add('hidden');
  document.getElementById('form-success')?.classList.remove('hidden');
  document.getElementById('form-success')?.focus();
}
