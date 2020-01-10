#   BAREOS® - Backup Archiving REcovery Open Sourced
#
#   Copyright (C) 2017-2020 Bareos GmbH & Co. KG
#
#   This program is Free Software; you can redistribute it and/or
#   modify it under the terms of version three of the GNU Affero General Public
#   License as published by the Free Software Foundation and included
#   in the file LICENSE.
#
#   This program is distributed in the hope that it will be useful, but
#   WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
#   Affero General Public License for more details.
#
#   You should have received a copy of the GNU Affero General Public License
#   along with this program; if not, write to the Free Software
#   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
#   02110-1301, USA.

install(
  FILES ${CMAKE_CURRENT_BINARY_DIR}/bareos
        ${CMAKE_CURRENT_BINARY_DIR}/btraceback
  PERMISSIONS OWNER_READ OWNER_WRITE OWNER_EXECUTE GROUP_READ GROUP_EXECUTE
              WORLD_READ WORLD_EXECUTE
  DESTINATION "${sbindir}"
)

install(
  FILES ${CMAKE_CURRENT_BINARY_DIR}/bareos-ctl-fd
  PERMISSIONS OWNER_READ OWNER_WRITE OWNER_EXECUTE GROUP_READ GROUP_EXECUTE
              WORLD_READ WORLD_EXECUTE
  DESTINATION "${scriptdir}"
  COMPONENT filedaemon
)

install(
  FILES btraceback.gdb
        btraceback.dbx
        btraceback.mdb
        bareos-ctl-funcs
        ${CMAKE_CURRENT_BINARY_DIR}/bareos
        ${CMAKE_CURRENT_BINARY_DIR}/bareos-config
        ${CMAKE_CURRENT_BINARY_DIR}/bareos-config-lib.sh
  PERMISSIONS OWNER_READ OWNER_WRITE OWNER_EXECUTE GROUP_READ GROUP_EXECUTE
              WORLD_READ WORLD_EXECUTE
  DESTINATION "${scriptdir}"
)

if(NOT client-only)
  install(
    FILES ${CMAKE_CURRENT_BINARY_DIR}/mtx-changer
          ${CMAKE_CURRENT_BINARY_DIR}/disk-changer
          ${CMAKE_CURRENT_BINARY_DIR}/bareos-explorer
          ${CMAKE_CURRENT_BINARY_DIR}/bareos-glusterfind-wrapper
          ${CMAKE_CURRENT_BINARY_DIR}/bareos-ctl-dir
          ${CMAKE_CURRENT_BINARY_DIR}/bareos-ctl-sd
          bareos-ctl-funcs
    PERMISSIONS OWNER_READ OWNER_WRITE OWNER_EXECUTE GROUP_READ GROUP_EXECUTE
                WORLD_READ WORLD_EXECUTE
    DESTINATION "${scriptdir}"
  )

  install(FILES mtx-changer.conf ${CMAKE_CURRENT_BINARY_DIR}/bareos-regress.conf
          DESTINATION "${confdir}"
  )

  install(
    FILES ${CMAKE_CURRENT_BINARY_DIR}/logrotate
    DESTINATION "${sysconfdir}/logrotate.d"
    RENAME bareos-dir
  )
endif()
