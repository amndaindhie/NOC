# TODO: Implement Auto-set Tanggal Selesai for Maintenance

## Tasks:
- [x] Modify `updateMaintenance` method in `NocCrudController.php` to automatically set `tanggal_selesai` to today's date when status is changed to "Selesai"
- [x] Implementation completed - ready for testing

## Details:
- Location: `app/Http/Controllers/Admin/NocCrudController.php`
- Method: `updateMaintenance`
- Logic: When `$request->status === 'Selesai'`, add `'tanggal_selesai' => now()` to the `$data` array
- Testing: Run the application with `php artisan serve` and test updating maintenance status to "Selesai"
