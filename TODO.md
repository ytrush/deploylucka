# TODO

## Task: Tambah tombol “lihat hasil history quiz” untuk quiz course (pretest/posttest)

- [ ] Pahami skema data: quiz_attempts saat ini hanya punya `materi_id`, belum ada tabel untuk quiz course.
- [ ] Rancang minimal yang feasible tanpa migrasi besar:
    - Buat history quiz course memakai tabel yang sama _atau_ (lebih benar) tambahkan kolom `course_id`/tabel baru.
- [ ] Implementasi back-end:
    - Update `CourseController::submitQuiz` untuk menyimpan `QuizAttempt` + `QuizAnswer`.
    - Tambahkan relasi/identifikasi attempt untuk quiz course.
- [ ] Implementasi front-end:
    - Update `resources/views/courses/quiz.blade.php` agar ada tombol untuk melihat riwayat.
    - Buat UI “history table” mirip yang ada di `materis/show.blade.php`.
- [ ] Uji alur:
    - Submit pretest/posttest → history muncul.
    - Review jawaban benar/salah tampil.
- [ ] Jalankan test/sanity check (kalau ada) / cek log error.
