import CrudHandler from "./crud_handler.js";

document.addEventListener("DOMContentLoaded", () => {
	const csrfEl = document.querySelector(
		'input[name="' + window.CSRF_TOKEN_NAME + '"]'
	);
	const SLOT_ID = window.SLOT_ID;

	if (!SLOT_ID) return;

	const csrfConfig = {
		tokenName: window.CSRF_TOKEN_NAME,
		tokenHash: csrfEl ? csrfEl.value : "",
	};

	// --- KONFIGURASI TABEL (Uploads + Nilai) ---
	const uploadConfig = {
		baseUrl: window.BASE_URL,
		entityName: "Data",
		readOnly: false,

		tableId: "uploadsTable",
		tableParentSelector: "#observasiTableContainer", // Event delegation parent

		csrf: csrfConfig,
		urls: {
			load: `guru/pbl_observasi/get_uploads/${SLOT_ID}`,
			delete: (id) => `guru/pbl_observasi/delete_upload/${id}`, // Delete File
		},
		deleteMethod: "POST",
		deleteNameField: "original_name",

        // Mapper
        dataMapper: (item, i) => {
            const uploadDate = new Date(item.created_at).toLocaleString("id-ID", {
                dateStyle: "medium",
                timeStyle: "short",
            });

            const fileUrl = `${window.BASE_URL}file/observasi/${item.file_name}`;
            
            // --- LOGIKA BARU: Generate Inisial Avatar ---
            // Mengambil huruf depan dari setiap kata nama siswa (maks 2 huruf)
            const initials = item.student_name
                .split(" ")
                .map((n) => n[0])
                .slice(0, 2)
                .join("")
                .toUpperCase();
            
            // Layout Kolom Nama dengan Avatar
            const studentHtml = `
                <div class="student-info-wrapper">
                    <div>
                        <strong class="text-dark">${item.student_name}</strong>
                        <div class="small text-muted mt-1">
                            <i class="bi bi-clock"></i> ${uploadDate}
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-file-earmark-text"></i> ${item.original_name}
                        </div>
                    </div>
                </div>
            `;
            // ---------------------------------------------

            let gradeBtnHtml = "";
            let gradeStatusHtml = "";
            let deleteGradeBtn = "";

            if (item.score !== null && item.score !== undefined) {
                // ... (Logika Status Nilai Tetap Sama) ...
                // Sederhanakan tampilan badge agar lebih modern (rounded-pill)
                 let badgeColor =
                    item.score >= 75
                        ? "bg-success"
                        : item.score >= 60
                        ? "bg-warning text-dark"
                        : "bg-danger";
                
                gradeStatusHtml = `
                    <div class="d-flex flex-column align-items-center">
                        <span class="badge ${badgeColor} rounded-pill px-3 mb-1" style="font-size: 0.9rem;">
                            ${item.score}
                        </span>
                        ${item.feedback ? `<i class="bi bi-chat-dots text-muted" title="${item.feedback}" data-bs-toggle="tooltip"></i>` : ''}
                    </div>
                `;
                
                gradeBtnHtml = `
                    <button class="btn btn-sm btn-outline-warning btn-grade" 
                        title="Edit Nilai"
                        data-user_id="${item.user_id}" 
                        data-student_name="${item.student_name}"
                        data-grade_id="${item.grade_id}"
                        data-score="${item.score}"
                        data-feedback="${item.feedback || ""}">
                        Edit
                    </button>
                `;
                
                deleteGradeBtn = `
                    <button class="btn btn-sm btn-outline-danger btn-delete-grade" 
                        title="Hapus Nilai"
                        data-id="${item.grade_id}" 
                        data-student_name="${item.student_name}">
                        Reset
                    </button>
                `;

            } else {
                gradeStatusHtml = `<span class="badge bg-secondary bg-opacity-25 text-secondary rounded-pill">Belum Dinilai</span>`;
                
                gradeBtnHtml = `
                    <button class="btn btn-sm btn-primary btn-grade" 
                        title="Beri Nilai"
                        data-user_id="${item.user_id}" 
                        data-student_name="${item.student_name}"
                        data-grade_id=""
                        data-score=""
                        data-feedback="">
                        Nilai
                    </button>
                `;
            }

            return [
                `<div class="text-center text-muted fw-bold">${i + 1}</div>`, // No
                studentHtml, // Nama Siswa & Avatar Baru
                `<div class="text-center"><a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light border text-primary"><i class="bi bi-download me-1"></i> Unduh</a></div>`,
                `<div class="text-center">${gradeStatusHtml}</div>`, // Status
                `<div class="text-center gap-1 d-flex justify-content-center">
                    ${gradeBtnHtml}
                    ${deleteGradeBtn}
                    <button class="btn btn-sm btn-outline-secondary btn-delete" 
                        title="Hapus File"
                        data-id="${item.id}" 
                        data-original_name="${item.student_name}">
                        Hapus
                    </button>
                 </div>`,
            ];
        },
		formPopulator: () => {},
		onAdd: () => {},
	};

	const handler = new CrudHandler(uploadConfig);
	handler.init();

	// ============================================================
	// LOGIKA MANUAL UNTUK MODAL PENILAIAN
	// ============================================================

	const gradeModalEl = document.getElementById("gradeModal");
	const gradeModal = new bootstrap.Modal(gradeModalEl);
	const gradeForm = document.getElementById("gradeForm");

	// 1. Event Listener Tombol "Beri Nilai" / "Edit Nilai"
	document
		.querySelector("#observasiTableContainer")
		.addEventListener("click", (e) => {
			const btn = e.target.closest(".btn-grade");
			if (btn) {
				// Isi Form Modal
				gradeForm.reset();
				document.getElementById("gradeId").value = btn.dataset.grade_id || "";
				document.getElementById("userIdInput").value = btn.dataset.user_id;
				document.getElementById("studentNameDisplay").value =
					btn.dataset.student_name;
				document.getElementById("scoreInput").value = btn.dataset.score || "";
				document.getElementById("feedbackInput").value =
					btn.dataset.feedback || "";

				gradeModal.show();
			}
		});

	// 2. Event Listener Submit Form Nilai
	gradeForm.addEventListener("submit", async (e) => {
		e.preventDefault();

		const formData = new FormData(gradeForm);

		try {
			const response = await fetch(
				`${window.BASE_URL}guru/pbl_observasi/save_grade`,
				{
					method: "POST",
					body: formData,
				}
			);
			const result = await response.json();

			// Update CSRF
			if (result.csrf_hash) {
				document
					.querySelectorAll(`input[name="${window.CSRF_TOKEN_NAME}"]`)
					.forEach((el) => (el.value = result.csrf_hash));
				csrfConfig.tokenHash = result.csrf_hash; // Update config handler juga
			}

			if (result.status === "success") {
				gradeModal.hide();
				Swal.fire({
					icon: "success",
					title: "Berhasil",
					text: result.message,
					timer: 1500,
					showConfirmButton: false,
				});
				handler.loadData(); // Reload tabel utama
			} else {
				Swal.fire("Gagal", result.message, "error");
			}
		} catch (error) {
			console.error(error);
			Swal.fire("Error", "Terjadi kesalahan server", "error");
		}
	});

	// 3. Event Listener Tombol "Hapus Nilai"
	document
		.querySelector("#observasiTableContainer")
		.addEventListener("click", async (e) => {
			const btn = e.target.closest(".btn-delete-grade");
			if (btn) {
				const id = btn.dataset.id;
				const name = btn.dataset.student_name;

				const confirm = await Swal.fire({
					title: "Hapus Nilai?",
					text: `Nilai untuk ${name} akan dihapus.`,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d33",
					confirmButtonText: "Ya, Hapus",
				});

				if (confirm.isConfirmed) {
					const formData = new FormData();
					formData.append("id", id);
					formData.append(window.CSRF_TOKEN_NAME, csrfConfig.tokenHash);

					try {
						const response = await fetch(
							`${window.BASE_URL}guru/pbl_observasi/delete_grade`,
							{
								method: "POST",
								body: formData,
							}
						);
						const result = await response.json();

						if (result.csrf_hash) {
							document
								.querySelectorAll(`input[name="${window.CSRF_TOKEN_NAME}"]`)
								.forEach((el) => (el.value = result.csrf_hash));
							csrfConfig.tokenHash = result.csrf_hash;
						}

						if (result.status === "success") {
							Swal.fire({
								icon: "success",
								title: "Terhapus",
								text: result.message,
								timer: 1000,
								showConfirmButton: false,
							});
							handler.loadData();
						} else {
							Swal.fire("Gagal", result.message, "error");
						}
					} catch (error) {
						Swal.fire("Error", "Gagal menghapus nilai", "error");
					}
				}
			}
		});
});
