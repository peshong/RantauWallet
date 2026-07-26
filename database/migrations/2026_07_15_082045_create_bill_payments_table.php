Schema::create('bill_payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('bill_id')->constrained()->onDelete('cascade');
    $table->decimal('amount', 12, 2);
    $table->date('paid_at');
    $table->timestamps();
});