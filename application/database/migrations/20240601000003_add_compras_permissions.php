<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Migration_Add_compras_permissions extends CI_Migration
{
    public function up()
    {
        // Busca a permissão de Administrador e adiciona as permissões de Compras
        $admin = $this->db->where('nome', 'Administrador')->get('permissoes')->row();
        if ($admin) {
            $perms = unserialize($admin->permissoes);
            if (is_array($perms)) {
                $perms['aCompra'] = '1';
                $perms['eCompra'] = '1';
                $perms['dCompra'] = '1';
                $perms['vCompra'] = '1';
                $this->db->where('idPermissao', $admin->idPermissao);
                $this->db->update('permissoes', ['permissoes' => serialize($perms)]);
            }
        }
    }

    public function down()
    {
        $admin = $this->db->where('nome', 'Administrador')->get('permissoes')->row();
        if ($admin) {
            $perms = unserialize($admin->permissoes);
            if (is_array($perms)) {
                unset($perms['aCompra'], $perms['eCompra'], $perms['dCompra'], $perms['vCompra']);
                $this->db->where('idPermissao', $admin->idPermissao);
                $this->db->update('permissoes', ['permissoes' => serialize($perms)]);
            }
        }
    }
}
