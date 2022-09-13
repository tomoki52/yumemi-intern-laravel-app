<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('企業名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->string('profile')->comment('プロフィール');
            $table->boolean('is_enable_interview')->default(false)->comment('面談可能か');
            $table->text('enable_interview_datetime')->nullable()->default(null)->comment('面談可能日時');
            $table->dateTime('created_at')->useCurrent()->comment('作成日時');
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
