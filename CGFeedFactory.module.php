<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGFeedFactory (c) 2016 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow creating RSS feeds from
#  user supplied data.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE

final class CGFeedFactory extends CGExtensions
{
    function IsPluginModule() { return TRUE; }
    function HasAdmin() { return TRUE; }
    function LazyLoadFrontend() { return FALSE; }
    function LazyLoadAdmin() { return TRUE; }
    function GetVersion() { return '1.1'; }
    function MinimumCMSVersion() { return '2.1.2'; }
    function GetDependencies() { array('CGExtensions'=>'1.53.1'); }
    function GetAdminDescription() { return $this->Lang('description'); }
    function GetAdminSection() { return 'content'; }
    function GetFriendlyName() { return $this->Lang('friendlyname'); }

    function VisibleToAdminUser()
    {
        return $this->CheckPermission('Modify Site Preferences');
    }

    public function InitializeFrontend()
    {
        $this->RestrictUnknownParams();
        \CGFeedFactory\smarty_plugins::init();
    }

} // End of class

?>
