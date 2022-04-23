<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrphansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orphans', function (Blueprint $table) {
            $table->id();
            $table->string('orphanNumber')->nullable();
            $table->string('orphanName');
            $table->string('mothersName');
            $table->string('mothersIdentity');
            $table->string('breadwinnerName');
            $table->string('relativeRelation');
            $table->string('breadwinnerIdentity');
            $table->string('phoneNumber');
            $table->string('accountNumber');
            $table->string('address');
            $table->string('educationalLevel');
            $table->string('guarantyType');
            $table->string('dob');
            $table->string('healthStatus');
            $table->string('disease');
            $table->string('orphanIdentity')->unique();
            $table->string('educationalAttainmentLevel');
            $table->boolean('gender');
            $table->string('fathersDeathDate');
            $table->string('causeOfDeath');
            $table->string('marketingDate')->nullable();
            $table->string('guarantyDate')->nullable();
            $table->boolean('status')->default(false);
            $table->string('personalPicture')->nullable();
            $table->string('birthCertificate')->nullable();
            $table->string('schoolCertificate')->nullable();
            $table->timestamps();
            $table->softDeletes();









        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orphans');
    }
}
