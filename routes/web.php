<?php

use App\Http\Controllers\admin_metodos\alunos\AlunosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';

use App\Http\Controllers\authentications\LoginController;
use App\Http\Controllers\dashboard\Admin;
use App\Http\Controllers\dashboard\Aluno;
use App\Http\Controllers\dashboard\Professor;
use App\Http\Controllers\admin_metodos\cadastrar\ModalidadeController;
use App\Http\Controllers\admin_metodos\cadastrar\ProfessorController;
use App\Http\Controllers\admin_metodos\cadastrar\EnderecoController;
use App\Http\Controllers\admin_metodos\cadastrar\TurmaController;

use App\Http\Controllers\aluno_controllers\anamnese\AnamneseController;
use App\Http\Controllers\aluno_controllers\turma\Turma_AlunoController;

use App\Http\Controllers\professor_metodos\chamada\ChamadaController;
use App\Http\Controllers\professor_metodos\turma\Turma_Professor;



use App\Http\Controllers\admin_metodos\relatorios\RelatorioDemandaController;
use App\Http\Controllers\admin_metodos\matriculas\MatriculaController;

// Main Page Route
Route::get('/', $controller_path . '\authentications\LoginController@index')->name('login');
Route::get('/register', $controller_path . '\authentications\RegisterBasic@index')->name('register');
Route::get('/login', $controller_path . '\authentications\LoginController@index')->name('login');
Route::get('/login/deslogar', $controller_path . '\authentications\LoginController@deslogar')->name('deslogar');
Route::get('/forgot-password', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('esqueceu-senha');

Route::post('/registrar/cadastro', $controller_path . '\authentications\RegisterBasic@store')->name('registrar-aluno');
Route::post('/logar', [LoginController::class, 'auth'])->name('logar');

Route::get('/conta/configuracao', [LoginController::class, 'configuracao'])->name('conta-configuracao')->middleware('auth');
Route::post('/salvar/configuracao', [LoginController::class, 'salvarConfiguracao'])->name('salvar-configuracao')->middleware('auth');


Route::group(['middleware' => ['auth', 'checkPermissao:Aluno']], function () {
    Route::prefix('/dashboard/aluno')->group(function () {
        Route::get('/', [Aluno::class, 'index'])->name('dashboard-aluno');

        Route::get('cadastro/anamnese', [AnamneseController::class, 'index'])->name('dashboard-aluno-cadastro-anamnese');
        Route::post('cadastrar/anamnese', [AnamneseController::class, 'store'])->name('cadastrar-anamnese');

        Route::get('cadastro/turma', [Turma_AlunoController::class, 'index'])->name('dashboard-aluno-cadastro-turma');
        Route::post('cadastro/turma', [Turma_AlunoController::class, 'storeListaEspera'])->name('cadastrar-lista-turma');
        Route::post('cadastro/filtrar', [Turma_AlunoController::class,'filtrarTurma'])->name('filtrar-turmas');
    });
});


Route::group(['middleware' => ['auth', 'checkPermissao:Professor']], function () {
    Route::prefix('/dashboard/professor')->group(function () {
        Route::get('/', [Professor::class, 'index'])->name('dashboard-professor');

        Route::get('/buscar/lista', [Turma_Professor::class, 'index'])->name('dashboard-professor-buscar-lista');
        Route::post('/buscar/lista-espera', [Turma_Professor::class, 'show'])->name('buscar-lista-espera');
        Route::post('aprovar/aluno', [Turma_Professor::class, 'aprovarAluno'])->name('aprovar-aluno');
        Route::post('desaprovar/aluno', [Turma_Professor::class, 'desaprovarAluno'])->name('desaprovar-aluno');

        Route::get('/buscar/chamada', [ChamadaController::class, 'index'])->name('dashboard-professor-buscar-chamada');
        Route::post('/buscar/aulas', [ChamadaController::class, 'showAulas'])->name('buscar-aulas');
        Route::post('/buscar/alunos/aula', [ChamadaController::class, 'showAlunosAula'])->name('buscar-alunos-aula');
        Route::post('/efetuar/chamada', [ChamadaController::class, 'efetuarChamada'])->name('efetuar-chamada');
        Route::post('/cancelar/chamada', [ChamadaController::class, 'cancelarChamada'])->name('cancelar-chamada');
        Route::post('/buscar/aula/cancelada', [ChamadaController::class, 'showAulaCancelada'])->name('mostra-aula-cancelada');

        Route::get('/buscar/alunos', [Turma_Professor::class, 'listarTurma'])->name('dashboard-professor-buscar-alunos');
        Route::post('/buscar/matriculas', [Turma_Professor::class, 'showMatriculas'])->name('buscar-matriculas');
        Route::post('buscar/aluno', [Turma_Professor::class, 'showAluno'])->name('buscar-aluno');
        Route::post('desmatricular/aluno', [Turma_Professor::class, 'updateMatricula'])->name('desmatricular-aluno');
    });
});


Route::group(['middleware' => ['auth', 'checkPermissao:Admin']], function () {
    Route::prefix('/dashboard/admin')->group(function () {
        Route::get('/', [Admin::class, 'index'])->name('dashboard-admin');

        Route::get('/cadastrar/modalidade', [ModalidadeController::class, 'index'])->name('dashboard-admin-cadastrar-modalidade');
        Route::get('/buscar/modalidades', [ModalidadeController::class, 'show'])->name('buscar-modalidades');
        Route::post('/cadastro/modalidade', [ModalidadeController::class, 'store'])->name('cadastrar-modalidade');
        Route::post('/edit/modalidade', [ModalidadeController::class, 'edit'])->name('edit-modalidade');
        Route::post('/delete/modalidade', [ModalidadeController::class, 'destroy'])->name('delete-modalidade');

        Route::get('/cadastrar/professor', [ProfessorController::class, 'index'])->name('dashboard-admin-cadastrar-professor');
        Route::get('/buscar/professores', [ProfessorController::class, 'show'])->name('buscar-professores');
        Route::post('/cadastro/professor', [ProfessorController::class, 'store'])->name('cadastrar-professor');
        Route::post('/edit/professor', [ProfessorController::class, 'edit'])->name('edit-professor');
        Route::post('/delete/professor', [ProfessorController::class, 'destroy'])->name('delete-professor');

        Route::get('/cadastrar/endereco', [EnderecoController::class, 'index'])->name('dashboard-admin-cadastrar-endereco');
        Route::get('/buscar/enderecos', [EnderecoController::class, 'show'])->name('buscar-enderecos');
        Route::post('/cadastro/endereco', [EnderecoController::class, 'store'])->name('cadastrar-endereco');
        Route::post('/edit/endereco', [EnderecoController::class, 'edit'])->name('edit-endereco');
        Route::post('/delete/endereco', [EnderecoController::class, 'destroy'])->name('delete-endereco');
        Route::post('/cadastro/bairro', [EnderecoController::class, 'storeBairro'])->name('cadastrar-bairro');

        Route::get('/cadastrar/turma', [TurmaController::class, 'index'])->name('dashboard-admin-cadastrar-turma');
        Route::get('/buscar/turmas', [TurmaController::class, 'show'])->name('buscar-turmas');
        Route::post('/cadastro/turma', [TurmaController::class, 'store'])->name('cadastrar-turma');
        Route::post('/edit/turma', [TurmaController::class, 'edit'])->name('edit-turma');
        Route::post('/delete/turma', [TurmaController::class, 'destroy'])->name('delete-turma');

        Route::get('/alunos', [AlunosController::class,'index'])->name('dashboard-admin-alunos');
        Route::get('/buscar/alunos', [AlunosController::class, 'show'])->name('buscar-alunos');
        Route::post('/buscar/aluno', [AlunosController::class, 'showAluno'])->name('buscar-dados-aluno');
        Route::post('/resetar/senha', [AlunosController::class, 'resetarSenha'])->name('resetar-senha');

        Route::get('/matriculas', [MatriculaController::class,'index'])->name('dashboard-admin-matriculas');
        Route::post('/buscar/matriculas/admin', [MatriculaController::class, 'showMatriculas'])->name('buscar-matriculas-admin');


        Route::get('/relatorios/demanda', [RelatorioDemandaController::class, 'index'])->name('dashboard-admin-relatorios-demanda');
        Route::get('/relatorio/demanda', [RelatorioDemandaController::class, 'quantidadeDemandaPorBairroModalidade'])->name('quantidadeDemandaPorBairroModalidade');
    });
});
