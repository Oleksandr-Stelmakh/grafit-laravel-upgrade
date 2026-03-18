let prod_type = null;

document.addEventListener('DOMContentLoaded', () => {

   // ===== 1. Клики на таблицах =====
   document.querySelectorAll('.table .row-clicable').forEach(row => {
      row.addEventListener('click', () => {
         window.location = row.dataset.href;
      });
   });

   // ===== 2. Конструктор цен =====
   const prodTypeEl = document.getElementById('prod_type');
   if (prodTypeEl) {
      prodTypeEl.addEventListener('change', function () {
         prod_type_change(this);
      });

      // Инициализируем при загрузке страницы
      prodTypeEl.dispatchEvent(new Event('change'));
   }

   document.querySelectorAll('.btn-calcprice').forEach(btn => {
      btn.addEventListener('click', btn_calcprice_onclick);
   });

   // ===== 3. Подсветка активного меню =====
   const pathPage = location.pathname.slice(1);
   if (pathPage.length > 0) {
      document.querySelectorAll('.navbar-nav a').forEach(link => {
         if (link.getAttribute('href').includes(pathPage)) {
            const li = link.closest('li');
            if (li) li.classList.add('active');
         }
      });
   }
});

// ===== 4. Функции =====

// Изменение вида продукции
function prod_type_change(obj) {
   prod_type = obj.value;

   const toggleHidden = (id, condition) => {
      const el = document.getElementById(id);
      if (el) el.hidden = !condition;
   }

   toggleHidden('gr_format_form', prod_type === '14579'); // бланк
   toggleHidden('gr_format_journal', prod_type === '14580'); // журнал
   toggleHidden('gr_num_sheets', prod_type === '14580'); // журнал
   toggleHidden('gr_stitch', prod_type === '14580'); // журнал
   toggleHidden('gr_cover_type', prod_type === '14580'); // журнал
   toggleHidden('gr_num_pages', prod_type === '14870'); // брошюра
}

// Рассчитать цену
function btn_calcprice_onclick() {

   const hideEl = id => { const el = document.getElementById(id); if (el) el.hidden = true; };
   const showEl = id => { const el = document.getElementById(id); if (el) el.hidden = false; };
   const setHtml = (id, html) => { const el = document.getElementById(id); if (el) el.innerHTML = html; };

   hideEl('calc_container');
   hideEl('calc_error');
   showEl('calc_waiting');

   setHtml('calc_name', '');
   setHtml('calc_num', '');
   setHtml('calc_full_price', '');
   setHtml('calc_price', '');
   setHtml('calc_sum', '');

   let format;
   if (prod_type === '14580') {
      format = document.getElementById('format_journal')?.value;
   } else {
      format = document.getElementById('format_form')?.value;
   }

   // Сбор параметров
   const params = new URLSearchParams({
      prod_type: document.getElementById('prod_type')?.value || '',
      paper_type: document.getElementById('paper_type')?.value || '',
      format: format || '',
      num_sheets: document.getElementById('num_sheets')?.value || '',
      stitch: document.getElementById('stitch')?.checked ? 1 : 0,
      numering: document.getElementById('numering')?.checked ? 1 : 0,
      cover_type: document.getElementById('cover_type')?.value || '',
      num: document.getElementById('num')?.value || '',
      discount: document.getElementById('discount')?.value || ''
   });

   fetch('/getprice/?' + params.toString())
      .then(response => response.json())
      .then(data => {
         hideEl('calc_waiting');

         if (data.error) {
            setHtml('calc_error', data.last_error_str || '');
            showEl('calc_error');
         } else {
            setHtml('calc_name', data.name || '');
            setHtml('calc_num', data.num || '');
            setHtml('calc_full_price', (data.full_price || 0).toFixed(3));
            setHtml('calc_price', (data.price || 0).toFixed(3));
            setHtml('calc_sum', (data.sum || 0).toFixed(2));
            showEl('calc_container');
         }
      })
      .catch(err => {
         console.error(err);
         hideEl('calc_waiting');
      });
}