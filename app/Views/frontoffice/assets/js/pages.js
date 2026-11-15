/* ============================================================
   WASLA — Page-specific behaviour
   ============================================================ */
(function () {
  "use strict";

  const DATA = window.WASLA_DATA;
  const icon = window.WASLA_icon;
  const toast = window.WASLA_toast || function () {};
  const t = window.WASLA_t || ((value) => value);

  function matchesName(name, query) {
    return !query || name.toLowerCase().includes(query) || t(name).toLowerCase().includes(query);
  }

  function setLoading(button, loading, label) {
    if (!button) return;
    button.disabled = loading;
    button.classList.toggle("is-loading", loading);
    button.setAttribute("aria-busy", String(loading));
    if (label) button.textContent = label;
  }

  function hydrate(root) {
    if (window.WASLA_hydrateIcons) window.WASLA_hydrateIcons(root || document);
  }

  function statusBadge(status) {
    const meta = DATA.statuses[status] || DATA.statuses.nodata;
    return `<span class="status-badge status-badge--${meta.className}">${meta.short}</span>`;
  }

  /* Carte --------------------------------------------------- */

  function setupCarte() {
    const list = document.querySelector("[data-zone-list]");
    if (!list || !DATA) return;

    const governorates = DATA.governorates;
    const counts = { total: governorates.length, normal: 0, watch: 0, outage: 0, nodata: 0 };
    governorates.forEach((zone) => {
      if (counts[zone.status] !== undefined) counts[zone.status]++;
    });

    document.querySelectorAll("[data-summary]").forEach((el) => {
      const key = el.getAttribute("data-summary");
      if (counts[key] !== undefined) el.textContent = counts[key];
    });
    document.querySelectorAll("[data-count]").forEach((el) => {
      const key = el.getAttribute("data-count");
      if (counts[key] !== undefined) el.textContent = counts[key];
    });

    let activeStatus = "all";
    let query = "";
    let selected = null;

    function filtered() {
      return governorates.filter((zone) => {
        const matchesStatus = activeStatus === "all" || zone.status === activeStatus;
        return matchesStatus && matchesName(zone.name, query);
      });
    }

    function renderList() {
      const rows = filtered();
      const empty = `<div class="empty-state">${icon("search")}<strong>Aucune zone trouvée</strong><p>Modifiez la recherche ou réinitialisez les filtres.</p></div>`;
      list.innerHTML = rows.length ? rows
        .map(
          (zone) => `
        <button class="zone-item${selected === zone.name ? " is-selected" : ""}" type="button" data-zone-item="${zone.name}">
          <span>
            <span class="zone-item__name">${zone.name}</span>
            <span class="zone-item__meta">${zone.zones} zones · ${zone.updated}</span>
          </span>
          <span class="zone-item__right">
            ${statusBadge(zone.status)}
            ${icon("chevron-right")}
          </span>
        </button>`
        )
        .join("") : empty;

      list.querySelectorAll("[data-zone-item]").forEach((button) => {
        button.addEventListener("click", () => {
          const name = button.getAttribute("data-zone-item");
          selected = name;
          highlight(name);
          if (window.WASLA_MAP) window.WASLA_MAP.selectZone(name);
        });
      });

      const visible = document.querySelector("[data-visible-count]");
      if (visible) visible.textContent = rows.length;
      const label = document.querySelector("[data-zone-count-label]");
      if (label) label.textContent = `${rows.length} zone${rows.length > 1 ? "s" : ""}`;

      if (window.WASLA_MAP) window.WASLA_MAP.applyFilters({ status: activeStatus, query });
    }

    function highlight(name) {
      list.querySelectorAll("[data-zone-item]").forEach((button) => {
        button.classList.toggle("is-selected", button.getAttribute("data-zone-item") === name);
      });
    }

    document.querySelectorAll("[data-status-filter]").forEach((chip) => {
      chip.addEventListener("click", () => {
        document.querySelectorAll("[data-status-filter]").forEach((item) => item.classList.remove("is-active"));
        chip.classList.add("is-active");
        activeStatus = chip.getAttribute("data-status-filter");
        renderList();
      });
    });

    const search = document.querySelector("[data-zone-search]");
    if (search) {
      search.addEventListener("input", () => {
        query = search.value.trim().toLowerCase();
        renderList();
      });
    }

    const reset = document.querySelector("[data-reset-filters]");
    if (reset) {
      reset.addEventListener("click", () => {
        activeStatus = "all";
        query = "";
        if (search) search.value = "";
        document.querySelectorAll("[data-status-filter]").forEach((item) => {
          item.classList.toggle("is-active", item.getAttribute("data-status-filter") === "all");
        });
        renderList();
      });
    }

    document.addEventListener("wasla:zone-select", (event) => {
      const name = event.detail && event.detail.zone ? event.detail.zone.name : null;
      if (!name) return;
      selected = name;
      highlight(name);
      const button = list.querySelector(`[data-zone-item="${name}"]`);
      if (button) button.scrollIntoView({ block: "nearest" });
    });

    renderList();
    setupReportModal();
  }

  function setupReportModal() {
    const modal = document.querySelector("[data-report-modal]");
    if (!modal || !DATA) return;

    const form = modal.querySelector("[data-report-form]");
    const zoneSelect = modal.querySelector("#report-zone");
    const address = modal.querySelector("#report-address");

    if (zoneSelect) {
      zoneSelect.innerHTML =
        '<option value="">Sélectionner un gouvernorat…</option>' +
        DATA.governorates.map((zone) => `<option value="${zone.name}">${zone.name}</option>`).join("");
    }

    let lastFocus = null;

    function open() {
      lastFocus = document.activeElement;
      modal.hidden = false;
      document.body.classList.add("no-scroll");
      requestAnimationFrame(() => {
        if (zoneSelect) zoneSelect.focus();
      });
    }

    function close() {
      modal.hidden = true;
      document.body.classList.remove("no-scroll");
      if (lastFocus && typeof lastFocus.focus === "function") lastFocus.focus();
    }

    document.querySelectorAll("[data-open-report]").forEach((button) => {
      button.addEventListener("click", open);
    });
    modal.querySelectorAll("[data-close-report]").forEach((button) => {
      button.addEventListener("click", close);
    });
    modal.addEventListener("click", (event) => {
      if (event.target === modal) close();
    });
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && !modal.hidden) close();
      if (event.key !== "Tab" || modal.hidden) return;
      const focusables = Array.from(
        modal.querySelectorAll("a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled])")
      ).filter((element) => element.offsetParent !== null);
      if (!focusables.length) return;
      const first = focusables[0];
      const last = focusables[focusables.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    });

    if (form) {
      form.addEventListener("submit", (event) => {
        event.preventDefault();
        const zoneOk = zoneSelect && zoneSelect.value;
        const addressOk = address && address.value.trim().length >= 3;
        if (zoneSelect) zoneSelect.classList.toggle("is-invalid", !zoneOk);
        if (address) address.classList.toggle("is-invalid", !addressOk);
        if (!zoneOk || !addressOk) {
          toast("Veuillez renseigner le gouvernorat et une adresse valide.");
          return;
        }
        const submit = form.querySelector('[type="submit"]');
        setLoading(submit, true, "Envoi…");
        window.setTimeout(() => {
          setLoading(submit, false, "Envoyer le signalement");
          close();
          form.reset();
          toast("Merci ! Votre signalement a bien été enregistré (démonstration).");
        }, 700);
      });
    }
  }

  /* Analyses ------------------------------------------------ */

  function setupAnalyses() {
    if (!DATA) return;

    const tbody = document.querySelector("[data-outage-table]");
    const zoneSelect = document.querySelector("[data-analysis-zone]");

    function renderTable(rows) {
      if (!tbody) return;
      if (!rows.length) {
        tbody.innerHTML = `<tr class="data-table__empty"><td colspan="5">Aucun incident récent pour ce gouvernorat.</td></tr>`;
        return;
      }
      tbody.innerHTML = rows
        .map(
          (row) => `
        <tr>
          <td><strong>${row.zone}</strong></td>
          <td>${row.type}</td>
          <td>${statusBadge(row.status)}</td>
          <td>${row.duration}</td>
          <td>${row.updated}</td>
        </tr>`
        )
        .join("");
    }

    if (zoneSelect) {
      zoneSelect.innerHTML =
        '<option value="">Tous les gouvernorats</option>' +
        DATA.governorates.map((zone) => `<option value="${zone.name}">${zone.name}</option>`).join("");
      zoneSelect.addEventListener("change", () => {
        const value = zoneSelect.value;
        const rows = DATA.analytics.outages.filter((row) => !value || row.zone.includes(value));
        renderTable(rows);
      });
    }

    renderTable(DATA.analytics.outages);
  }

  /* Services ------------------------------------------------ */

  function setupServices() {
    const grid = document.querySelector("[data-services-grid]");
    if (!grid || !DATA) return;

    grid.innerHTML = DATA.services
      .map(
        (service) => `
      <article class="service-card" id="${service.id}">
        <span class="service-card__icon service-card__icon--${service.tone}" data-icon="${service.icon}"></span>
        <h3>${service.title}</h3>
        <p>${service.description}</p>
        <ul>${service.points
          .map((point) => `<li><span data-icon="check"></span>${point}</li>`)
          .join("")}</ul>
        <a class="text-link" href="${service.link}">Découvrir ${icon("arrow-right")}</a>
      </article>`
      )
      .join("");

    hydrate(grid);
  }

  /* Connexion ----------------------------------------------- */

  function setupLogin() {
    const form = document.querySelector("[data-login-form]");
    if (!form) return;

    const email = form.querySelector("#login-email");
    const password = form.querySelector("#login-password");
    const emailError = form.querySelector('[data-error-for="email"]');
    const passwordError = form.querySelector('[data-error-for="password"]');
    const toggle = form.querySelector("[data-toggle-password]");
    const submit = form.querySelector("[data-login-submit]");

    if (toggle && password) {
      toggle.addEventListener("click", () => {
        const showing = password.type === "text";
        password.type = showing ? "password" : "text";
        toggle.innerHTML = icon(showing ? "eye" : "eye-off");
        toggle.setAttribute("aria-label", showing ? "Afficher le mot de passe" : "Masquer le mot de passe");
      });
    }

    function clear(field, error) {
      if (!field) return;
      field.classList.remove("is-invalid");
      if (error) error.classList.remove("is-visible");
    }

    if (email) email.addEventListener("input", () => clear(email, emailError));
    if (password) password.addEventListener("input", () => clear(password, passwordError));

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      let valid = true;

      const emailValue = email ? email.value.trim() : "";
      const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);
      if (email) email.classList.toggle("is-invalid", !emailOk);
      if (emailError) emailError.classList.toggle("is-visible", !emailOk);
      if (!emailOk) valid = false;

      const passwordOk = password && password.value.length > 0;
      if (password) password.classList.toggle("is-invalid", !passwordOk);
      if (passwordError) passwordError.classList.toggle("is-visible", !passwordOk);
      if (!passwordOk) valid = false;

      if (!valid) {
        toast("Veuillez corriger les champs indiqués.");
        return;
      }

      // Champs valides : on laisse le formulaire partir vers le serveur (PHP vérifie le compte).
      setLoading(submit, true, "Connexion…");
      form.submit();
    });
  }

  /* Inscription --------------------------------------------- */

  function setupRegister() {
    const form = document.querySelector("[data-register-form]");
    if (!form) return;

    const submit = form.querySelector("[data-register-submit]");
    const nameRe = /^[\p{L}][\p{L}' -]{1,79}$/u;
    const rules = {
      prenom: (v) => nameRe.test(v.trim()) || "Veuillez saisir un prénom valide (lettres uniquement).",
      nom: (v) => nameRe.test(v.trim()) || "Veuillez saisir un nom valide (lettres uniquement).",
      email: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) || "Veuillez saisir une adresse e-mail valide.",
      telephone: (v) => {
        const t = v.replace(/[\s.-]/g, "");
        return t === "" || /^(\+216)?[2-9]\d{7}$/.test(t) || "Numéro tunisien à 8 chiffres attendu (ex. 22 123 456).";
      },
      gouvernorat: (v) => v !== "" || "Veuillez choisir votre gouvernorat.",
      password: (v) => (v.length >= 8 && /[A-Za-z]/.test(v) && /\d/.test(v)) || "Au moins 8 caractères, dont une lettre et un chiffre.",
      password_confirm: (v) => v === form.elements.password.value || "Les mots de passe ne correspondent pas.",
      terms: (_, el) => el.checked || "Veuillez accepter les conditions d'utilisation."
    };

    function check(name) {
      const el = form.elements[name];
      const error = form.querySelector(`[data-error-for="${name}"]`);
      const result = rules[name](el.value, el);
      const ok = result === true;
      el.classList.toggle("is-invalid", !ok);
      if (error) {
        error.textContent = ok ? "" : result;
        error.classList.toggle("is-visible", !ok);
      }
      return ok;
    }

    Object.keys(rules).forEach((name) => {
      const el = form.elements[name];
      if (!el) return;
      el.addEventListener(el.type === "checkbox" || el.tagName === "SELECT" ? "change" : "blur", () => check(name));
    });

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const valid = Object.keys(rules).map(check).every(Boolean);
      if (!valid) {
        toast("Veuillez corriger les champs indiqués.");
        const first = form.querySelector(".is-invalid");
        if (first) first.focus();
        return;
      }
      setLoading(submit, true, "Création du compte…");
      form.submit();
    });
  }

  /* Init ---------------------------------------------------- */

  document.addEventListener("DOMContentLoaded", () => {
    setupCarte();
    setupAnalyses();
    setupServices();
    setupLogin();
    setupRegister();
    hydrate(document);
  });
})();
