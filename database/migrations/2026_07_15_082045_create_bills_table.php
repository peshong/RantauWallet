Schema::create('bills', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->decimal('amount', 12, 2);
    $table->date('due_date');
    $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
    $table->timestamps();
});