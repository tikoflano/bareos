<? require_once("inc/header.php"); ?>
<table>
</tr>
<tr>
        <td class="content">

<pre>
                
                
Projects:
                     Bacula Projects Roadmap 
                Prioritized by user vote 07 December 2005
                    Status updated 30 July 2006

Summary:
Item  1:  Implement data encryption (as opposed to comm encryption)
Item  2:  Implement Migration that moves Jobs from one Pool to another.
Item  3:  Accurate restoration of renamed/deleted files from
Item  4:  Implement a Bacula GUI/management tool using Python.
Item  5:  Implement Base jobs.
Item  6:  Allow FD to initiate a backup
Item  7:  Improve Bacula's tape and drive usage and cleaning management.
Item  8:  Implement creation and maintenance of copy pools
Item  9:  Implement new {Client}Run{Before|After}Job feature.
Item 10:  Merge multiple backups (Synthetic Backup or Consolidation).
Item 11:  Deletion of Disk-Based Bacula Volumes
Item 12:  Directive/mode to backup only file changes, not entire file
Item 13:  Multiple threads in file daemon for the same job
Item 14:  Implement red/black binary tree routines.
Item 15:  Add support for FileSets in user directories  CACHEDIR.TAG
Item 16:  Implement extraction of Win32 BackupWrite data.
Item 17:  Implement a Python interface to the Bacula catalog.
Item 18:  Archival (removal) of User Files to Tape
Item 19:  Add Plug-ins to the FileSet Include statements.
Item 20:  Implement more Python events in Bacula.
Item 21:  Quick release of FD-SD connection after backup.
Item 22:  Permit multiple Media Types in an Autochanger
Item 23:  Allow different autochanger definitions for one autochanger.
Item 24:  Automatic disabling of devices
Item 25:  Implement huge exclude list support using hashing.


Below, you will find more information on future projects:

Item  1:  Implement data encryption (as opposed to comm encryption)
  Date:   28 October 2005
  Origin: Sponsored by Landon and 13 contributors to EFF.
  Status: Done: Landon Fuller has implemented this in 1.39.x.
                  
  What:   Currently the data that is stored on the Volume is not
          encrypted. For confidentiality, encryption of data at
          the File daemon level is essential. 
          Data encryption encrypts the data in the File daemon and
          decrypts the data in the File daemon during a restore.

  Why:    Large sites require this.

Item 2:   Implement Migration that moves Jobs from one Pool to another.
  Origin: Sponsored by Riege Software International GmbH. Contact:
          Daniel Holtkamp <holtkamp at riege dot com>
  Date:   28 October 2005
  Status: 90% complete: Working in 1.39, more to do. Assigned to
          Kern.

  What:   The ability to copy, move, or archive data that is on a
          device to another device is very important. 

  Why:    An ISP might want to backup to disk, but after 30 days
          migrate the data to tape backup and delete it from
          disk.  Bacula should be able to handle this
          automatically.  It needs to know what was put where,
          and when, and what to migrate -- it is a bit like
          retention periods.  Doing so would allow space to be
          freed up for current backups while maintaining older
          data on tape drives.

  Notes:   Riege Software have asked for the following migration
           triggers:
           Age of Job
           Highwater mark (stopped by Lowwater mark?)
                            
  Notes:  Migration could be additionally triggered by:
           Number of Jobs
           Number of Volumes

Item  3:  Accurate restoration of renamed/deleted files from
          Incremental/Differential backups
  Date:   28 November 2005
  Origin: Martin Simmons (martin at lispworks dot com)
  Status:

  What:   When restoring a fileset for a specified date (including "most
          recent"), Bacula should give you exactly the files and directories
          that existed at the time of the last backup prior to that date.

          Currently this only works if the last backup was a Full backup.
          When the last backup was Incremental/Differential, files and
          directories that have been renamed or deleted since the last Full
          backup are not currently restored correctly.  Ditto for files with
          extra/fewer hard links than at the time of the last Full backup.

  Why:    Incremental/Differential would be much more useful if this worked.

  Notes:  Item 14 (Merging of multiple backups into a single one) seems to
          rely on this working, otherwise the merged backups will not be
          truly equivalent to a Full backup.  

          Kern: notes shortened. This can be done without the need for 
          inodes. It is essentially the same as the current Verify job,
          but one additional database record must be written, which does 
          not need any database change.

          Kern: see if we can correct restoration of directories if
          replace=ifnewer is set.  Currently, if the directory does not
          exist, a "dummy" directory is created, then when all the files
          are updated, the dummy directory is newer so the real values
          are not updated.

Item 4:   Implement a Bacula GUI/management tool using Python.
  Origin: Kern
  Date:   28 October 2005
  Status: Lucus is working on this for Python GTK+.

  What:   Implement a Bacula console, and management tools
          using Python and Qt or GTK.

  Why:    Don't we already have a wxWidgets GUI?  Yes, but
          it is written in C++ and changes to the user interface
          must be hand tailored using C++ code. By developing
          the user interface using Qt designer, the interface
          can be very easily updated and most of the new Python       
          code will be automatically created.  The user interface
          changes become very simple, and only the new features
          must be implement.  In addition, the code will be in
          Python, which will give many more users easy (or easier)
          access to making additions or modifications.

 Notes:   This is currently being implemented using Python-GTK by       
          Lucas Di Pentima <lucas at lunix dot com dot ar>

Item 5:   Implement Base jobs.
  Date:   28 October 2005
  Origin: Kern
  Status: 
  
  What:   A base job is sort of like a Full save except that you 
          will want the FileSet to contain only files that are
          unlikely to change in the future (i.e.  a snapshot of
          most of your system after installing it).  After the
          base job has been run, when you are doing a Full save,
          you specify one or more Base jobs to be used.  All
          files that have been backed up in the Base job/jobs but
          not modified will then be excluded from the backup.
          During a restore, the Base jobs will be automatically
          pulled in where necessary.

  Why:    This is something none of the competition does, as far as
          we know (except perhaps BackupPC, which is a Perl program that
          saves to disk only).  It is big win for the user, it
          makes Bacula stand out as offering a unique
          optimization that immediately saves time and money.
          Basically, imagine that you have 100 nearly identical
          Windows or Linux machine containing the OS and user
          files.  Now for the OS part, a Base job will be backed
          up once, and rather than making 100 copies of the OS,
          there will be only one.  If one or more of the systems
          have some files updated, no problem, they will be
          automatically restored.

  Notes:  Huge savings in tape usage even for a single machine.
          Will require more resources because the DIR must send
          FD a list of files/attribs, and the FD must search the
          list and compare it for each file to be saved.

Item  6:  Allow FD to initiate a backup
  Origin: Frank Volf (frank at deze dot org)
  Date:   17 November 2005
  Status:

   What:  Provide some means, possibly by a restricted console that
          allows a FD to initiate a backup, and that uses the connection
          established by the FD to the Director for the backup so that
          a Director that is firewalled can do the backup.

   Why:   Makes backup of laptops much easier.

Item  7:  Improve Bacula's tape and drive usage and cleaning management.
  Date:   8 November 2005, November 11, 2005
  Origin: Adam Thornton <athornton at sinenomine dot net>,
          Arno Lehmann <al at its-lehmann dot de>
  Status:

  What:   Make Bacula manage tape life cycle information, tape reuse
          times and drive cleaning cycles.

  Why:    All three parts of this project are important when operating
          backups.
          We need to know which tapes need replacement, and we need to
          make sure the drives are cleaned when necessary.  While many
          tape libraries and even autoloaders can handle all this
          automatically, support by Bacula can be helpful for smaller
          (older) libraries and single drives.  Limiting the number of
          times a tape is used might prevent tape errors when using
          tapes until the drives can't read it any more.  Also, checking
          drive status during operation can prevent some failures (as I
          [Arno] had to learn the hard way...)

  Notes:  First, Bacula could (and even does, to some limited extent)
          record tape and drive usage.  For tapes, the number of mounts,
          the amount of data, and the time the tape has actually been
          running could be recorded.  Data fields for Read and Write
          time and Number of mounts already exist in the catalog (I'm
          not sure if VolBytes is the sum of all bytes ever written to
          that volume by Bacula).  This information can be important
          when determining which media to replace.  The ability to mark
          Volumes as "used up" after a given number of write cycles
          should also be implemented so that a tape is never actually
          worn out.  For the tape drives known to Bacula, similar
          information is interesting to determine the device status and
          expected life time: Time it's been Reading and Writing, number
          of tape Loads / Unloads / Errors.  This information is not yet
          recorded as far as I [Arno] know.  A new volume status would
          be necessary for the new state, like "Used up" or "Worn out".
          Volumes with this state could be used for restores, but not
          for writing. These volumes should be migrated first (assuming
          migration is implemented) and, once they are no longer needed,
          could be moved to a Trash pool.

          The next step would be to implement a drive cleaning setup.
          Bacula already has knowledge about cleaning tapes.  Once it
          has some information about cleaning cycles (measured in drive
          run time, number of tapes used, or calender days, for example)
          it can automatically execute tape cleaning (with an
          autochanger, obviously) or ask for operator assistance loading
          a cleaning tape.

          The final step would be to implement TAPEALERT checks not only
          when changing tapes and only sending the information to the
          administrator, but rather checking after each tape error,
          checking on a regular basis (for example after each tape
          file), and also before unloading and after loading a new tape.
          Then, depending on the drives TAPEALERT state and the known
          drive cleaning state Bacula could automatically schedule later
          cleaning, clean immediately, or inform the operator.

          Implementing this would perhaps require another catalog change
          and perhaps major changes in SD code and the DIR-SD protocol,
          so I'd only consider this worth implementing if it would
          actually be used or even needed by many people.

          Implementation of these projects could happen in three distinct
          sub-projects: Measuring Tape and Drive usage, retiring
          volumes, and handling drive cleaning and TAPEALERTs.

Item  8:  Implement creation and maintenance of copy pools
  Date:   27 November 2005
  Origin: David Boyes (dboyes at sinenomine dot net)
  Status:

  What:   I would like Bacula to have the capability to write copies
          of backed-up data on multiple physical volumes selected
          from different pools without transferring the data
          multiple times, and to accept any of the copy volumes
          as valid for restore.

  Why:    In many cases, businesses are required to keep offsite
          copies of backup volumes, or just wish for simple
          protection against a human operator dropping a storage
          volume and damaging it. The ability to generate multiple
          volumes in the course of a single backup job allows
          customers to simple check out one copy and send it
          offsite, marking it as out of changer or otherwise
          unavailable. Currently, the library and magazine
          management capability in Bacula does not make this process
          simple.

          Restores would use the copy of the data on the first
          available volume, in order of copy pool chain definition.

          This is also a major scalability issue -- as the number of
          clients increases beyond several thousand, and the volume
          of data increases, transferring the data multiple times to
          produce additional copies of the backups will become
          physically impossible due to transfer speed
          issues. Generating multiple copies at server side will
          become the only practical option. 

  How:    I suspect that this will require adding a multiplexing
          SD that appears to be a SD to a specific FD, but 1-n FDs
          to the specific back end SDs managing the primary and copy
          pools.  Storage pools will also need to acquire parameters
          to define the pools to be used for copies. 

  Notes:  I would commit some of my developers' time if we can agree
          on the design and behavior. 

Item  9:  Implement new {Client}Run{Before|After}Job feature.
  Date:   26 September 2005
  Origin: Phil Stracchino
  Status: Done. This has been implemented by Eric Bollengier

  What:   Some time ago, there was a discussion of RunAfterJob and
          ClientRunAfterJob, and the fact that they do not run after failed
          jobs.  At the time, there was a suggestion to add a
          RunAfterFailedJob directive (and, presumably, a matching
          ClientRunAfterFailedJob directive), but to my knowledge these
          were never implemented.

          The current implementation doesn't permit to add new feature easily.

          An alternate way of approaching the problem has just occurred to
          me.  Suppose the RunBeforeJob and RunAfterJob directives were
          expanded in a manner like this example:

          RunScript {
              Command = "/opt/bacula/etc/checkhost %c"
              RunsOnClient = No          # default
              AbortJobOnError = Yes      # default
              RunsWhen = Before
          }
          RunScript {
              Command = c:/bacula/systemstate.bat
              RunsOnClient = yes
              AbortJobOnError = No
              RunsWhen = After
              RunsOnFailure = yes
          }

          RunScript {
              Command = c:/bacula/deletestatefile.bat
              Target = rico-fd
              RunsWhen = Always
          }

          It's now possible to specify more than 1 command per Job.
          (you can stop your database and your webserver without a script)

          ex :
          Job {
              Name = "Client1"
              JobDefs = "DefaultJob"
              Write Bootstrap = "/tmp/bacula/var/bacula/working/Client1.bsr"
              FileSet = "Minimal"

              RunBeforeJob = "echo test before ; echo test before2"       
              RunBeforeJob = "echo test before (2nd time)"
              RunBeforeJob = "echo test before (3rd time)"
              RunAfterJob = "echo test after"
              ClientRunAfterJob = "echo test after client"

              RunScript {
                Command = "echo test RunScript in error"
                Runsonclient = yes
                RunsOnSuccess = no
                RunsOnFailure = yes
                RunsWhen = After            # never by default
              }
              RunScript {
                Command = "echo test RunScript on success"
                Runsonclient = yes
                RunsOnSuccess = yes # default
                RunsOnFailure = no  # default
                RunsWhen = After
              }
          }

  Why:    It would be a significant change to the structure of the
          directives, but allows for a lot more flexibility, including
          RunAfter commands that will run regardless of whether the job
          succeeds, or RunBefore tasks that still allow the job to run even
          if that specific RunBefore fails.

  Notes:  (More notes from Phil, Kern, David and Eric)
          I would prefer to have a single new Resource called
          RunScript.

            RunsWhen = After|Before|Always
            RunsAtJobLevels = All|Full|Diff|Inc # not yet implemented

          The AbortJobOnError, RunsOnSuccess and RunsOnFailure directives
          could be optional, and possibly RunWhen as well.

          AbortJobOnError would be ignored unless RunsWhen was set to Before
          and would default to Yes if omitted.
          If AbortJobOnError was set to No, failure of the script
          would still generate a warning.

          RunsOnSuccess would be ignored unless RunsWhen was set to After
          (or RunsBeforeJob set to No), and default to Yes.

          RunsOnFailure would be ignored unless RunsWhen was set to After,
          and default to No.

          Allow having the before/after status on the script command
          line so that the same script can be used both before/after.

Item 10:  Merge multiple backups (Synthetic Backup or Consolidation).
  Origin: Marc Cousin and Eric Bollengier 
  Date:   15 November 2005
  Status: Waiting implementation. Depends on first implementing 
          project Item 2 (Migration).

  What:   A merged backup is a backup made without connecting to the Client.
          It would be a Merge of existing backups into a single backup.
          In effect, it is like a restore but to the backup medium.

          For instance, say that last Sunday we made a full backup.  Then
          all week long, we created incremental backups, in order to do
          them fast.  Now comes Sunday again, and we need another full.
          The merged backup makes it possible to do instead an incremental
          backup (during the night for instance), and then create a merged
          backup during the day, by using the full and incrementals from
          the week.  The merged backup will be exactly like a full made
          Sunday night on the tape, but the production interruption on the
          Client will be minimal, as the Client will only have to send
          incrementals.

          In fact, if it's done correctly, you could merge all the
          Incrementals into single Incremental, or all the Incrementals
          and the last Differential into a new Differential, or the Full,
          last differential and all the Incrementals into a new Full
          backup.  And there is no need to involve the Client.

  Why:    The benefit is that :
          - the Client just does an incremental ;
          - the merged backup on tape is just as a single full backup,
            and can be restored very fast.

          This is also a way of reducing the backup data since the old
          data can then be pruned (or not) from the catalog, possibly
          allowing older volumes to be recycled

Item 11:  Deletion of Disk-Based Bacula Volumes
  Date:   Nov 25, 2005
  Origin: Ross Boylan <RossBoylan at stanfordalumni dot org> (edited
          by Kern)
  Status:         

   What:  Provide a way for Bacula to automatically remove Volumes
          from the filesystem, or optionally to truncate them.
          Obviously, the Volume must be pruned prior removal.

  Why:    This would allow users more control over their Volumes and
          prevent disk based volumes from consuming too much space.

  Notes:  The following two directives might do the trick:

          Volume Data Retention = <time period>
          Remove Volume After = <time period>

          The migration project should also remove a Volume that is
          migrated. This might also work for tape Volumes.

Item 12:  Directive/mode to backup only file changes, not entire file
  Date:   11 November 2005
  Origin: Joshua Kugler <joshua dot kugler at uaf dot edu>
          Marek Bajon <mbajon at bimsplus dot com dot pl>
  Status: 

  What:   Currently when a file changes, the entire file will be backed up in
          the next incremental or full backup.  To save space on the tapes
          it would be nice to have a mode whereby only the changes to the
          file would be backed up when it is changed.

  Why:    This would save lots of space when backing up large files such as 
          logs, mbox files, Outlook PST files and the like.

  Notes:  This would require the usage of disk-based volumes as comparing 
          files would not be feasible using a tape drive.

Item 13:  Multiple threads in file daemon for the same job
  Date:   27 November 2005
  Origin: Ove Risberg (Ove.Risberg at octocode dot com)
  Status:

  What:   I want the file daemon to start multiple threads for a backup
          job so the fastest possible backup can be made.

          The file daemon could parse the FileSet information and start
          one thread for each File entry located on a separate
          filesystem.

          A configuration option in the job section should be used to
          enable or disable this feature. The configuration option could
          specify the maximum number of threads in the file daemon.

          If the theads could spool the data to separate spool files
          the restore process will not be much slower.

  Why:    Multiple concurrent backups of a large fileserver with many
          disks and controllers will be much faster.

  Notes:  I am willing to try to implement this but I will probably
          need some help and advice.  (No problem -- Kern)

Item 14:  Implement red/black binary tree routines.
  Date:   28 October 2005
  Origin: Kern
  Status: Class code is complete. Code needs to be integrated into
          restore tree code.

  What:   Implement a red/black binary tree class. This could 
          then replace the current binary insert/search routines
          used in the restore in memory tree.  This could significantly
          speed up the creation of the in memory restore tree.

  Why:    Performance enhancement.

Item 15:  Add support for FileSets in user directories  CACHEDIR.TAG
  Origin: Norbert Kiesel <nkiesel at tbdnetworks dot com>
  Date:   21 November 2005
  Status: (I think this is better done using a Python event that I
           will implement in version 1.39.x).

  What:   CACHDIR.TAG is a proposal for identifying directories which
          should be ignored for archiving/backup.  It works by ignoring
          directory trees which have a file named CACHEDIR.TAG with a
          specific content.  See
          http://www.brynosaurus.com/cachedir/spec.html
          for details.

          From Peter Eriksson:
          I suggest that if this is implemented (I've also asked for this
          feature some year ago) that it is made compatible with Legato
          Networkers ".nsr" files where you can specify a lot of options on
          how to handle files/directories (including denying further
          parsing of .nsr files lower down into the directory trees).  A
          PDF version of the .nsr man page can be viewed at:

          http://www.ifm.liu.se/~peter/nsr.pdf

  Why:    It's a nice alternative to "exclude" patterns for directories
          which don't have regular pathnames.  Also, it allows users to
          control backup for themselves.  Implementation should be pretty
          simple.  GNU tar >= 1.14 or so supports it, too.

  Notes:  I envision this as an optional feature to a fileset
          specification.


Item 16:  Implement extraction of Win32 BackupWrite data.
  Origin: Thorsten Engel <thorsten.engel at matrix-computer dot com>
  Date:   28 October 2005
  Status: Done. Assigned to Thorsten. Implemented in current CVS

  What:   This provides the Bacula File daemon with code that
          can pick apart the stream output that Microsoft writes
          for BackupWrite data, and thus the data can be read
          and restored on non-Win32 machines.

  Why:    BackupWrite data is the portable=no option in Win32
          FileSets, and in previous Baculas, this data could
          only be extracted using a Win32 FD. With this new code,
          the Windows data can be extracted and restored on
          any OS.


Item 18:  Implement a Python interface to the Bacula catalog.
  Date:   28 October 2005
  Origin: Kern
  Status: 

  What:   Implement an interface for Python scripts to access
          the catalog through Bacula.

  Why:    This will permit users to customize Bacula through
          Python scripts.

Item 18:  Archival (removal) of User Files to Tape

  Date:   Nov. 24/2005 

  Origin: Ray Pengelly [ray at biomed dot queensu dot ca
  Status: 

  What:   The ability to archive data to storage based on certain parameters
          such as age, size, or location.  Once the data has been written to
          storage and logged it is then pruned from the originating
          filesystem. Note! We are talking about user's files and not
          Bacula Volumes.

  Why:    This would allow fully automatic storage management which becomes
          useful for large datastores.  It would also allow for auto-staging
          from one media type to another.

          Example 1) Medical imaging needs to store large amounts of data.
          They decide to keep data on their servers for 6 months and then put
          it away for long term storage.  The server then finds all files
          older than 6 months writes them to tape.  The files are then removed
          from the server.

          Example 2) All data that hasn't been accessed in 2 months could be
          moved from high-cost, fibre-channel disk storage to a low-cost
          large-capacity SATA disk storage pool which doesn't have as quick of
          access time.  Then after another 6 months (or possibly as one
          storage pool gets full) data is migrated to Tape.

Item 19:  Add Plug-ins to the FileSet Include statements.
  Date:   28 October 2005
  Origin:
  Status: Partially coded in 1.37 -- much more to do.

  What:   Allow users to specify wild-card and/or regular
          expressions to be matched in both the Include and
          Exclude directives in a FileSet.  At the same time,
          allow users to define plug-ins to be called (based on
          regular expression/wild-card matching).

  Why:    This would give the users the ultimate ability to control
          how files are backed up/restored.  A user could write a
          plug-in knows how to backup his Oracle database without
          stopping/starting it, for example.

Item 20:  Implement more Python events in Bacula.
  Date:   28 October 2005
  Origin: 
  Status: 

  What:   Allow Python scripts to be called at more places 
          within Bacula and provide additional access to Bacula
          internal variables.

  Why:    This will permit users to customize Bacula through
          Python scripts.

  Notes:  Recycle event
          Scratch pool event
          NeedVolume event
          MediaFull event
           
          Also add a way to get a listing of currently running
          jobs (possibly also scheduled jobs).


Item 21:  Quick release of FD-SD connection after backup.
  Origin: Frank Volf (frank at deze dot org)
  Date:   17 November 2005
  Status:

   What:  In the Bacula implementation a backup is finished after all data
          and attributes are successfully written to storage.  When using a
          tape backup it is very annoying that a backup can take a day,
          simply because the current tape (or whatever) is full and the
          administrator has not put a new one in.  During that time the
          system cannot be taken off-line, because there is still an open
          session between the storage daemon and the file daemon on the
          client.

          Although this is a very good strategy for making "safe backups"
          This can be annoying for e.g.  laptops, that must remain
          connected until the backup is completed.

          Using a new feature called "migration" it will be possible to
          spool first to harddisk (using a special 'spool' migration
          scheme) and then migrate the backup to tape.

          There is still the problem of getting the attributes committed.
          If it takes a very long time to do, with the current code, the
          job has not terminated, and the File daemon is not freed up.  The
          Storage daemon should release the File daemon as soon as all the
          file data and all the attributes have been sent to it (the SD).
          Currently the SD waits until everything is on tape and all the
          attributes are transmitted to the Director before signaling
          completion to the FD. I don't think I would have any problem
          changing this.  The reason is that even if the FD reports back to
          the Dir that all is OK, the job will not terminate until the SD
          has done the same thing -- so in a way keeping the SD-FD link
          open to the very end is not really very productive ...

   Why:   Makes backup of laptops much easier.

Item 22:  Permit multiple Media Types in an Autochanger
  Origin: Kern
  Status: Done. Implemented in 1.38.9 (I think).  

  What:   Modify the Storage daemon so that multiple Media Types
          can be specified in an autochanger. This would be somewhat
          of a simplistic implementation in that each drive would
          still be allowed to have only one Media Type.  However,
          the Storage daemon will ensure that only a drive with
          the Media Type that matches what the Director specifies
          is chosen.

  Why:    This will permit user with several different drive types
          to make full use of their autochangers.

Item 23:  Allow different autochanger definitions for one autochanger.
  Date:   28 October 2005
  Origin: Kern
  Status: 

  What:   Currently, the autochanger script is locked based on
          the autochanger. That is, if multiple drives are being
          simultaneously used, the Storage daemon ensures that only
          one drive at a time can access the mtx-changer script.
          This change would base the locking on the control device,
          rather than the autochanger. It would then permit two autochanger
          definitions for the same autochanger, but with different 
          drives. Logically, the autochanger could then be "partitioned"
          for different jobs, clients, or class of jobs, and if the locking
          is based on the control device (e.g. /dev/sg0) the mtx-changer
          script will be locked appropriately.

  Why:    This will permit users to partition autochangers for specific
          use. It would also permit implementation of multiple Media
          Types with no changes to the Storage daemon.

Item 24:  Automatic disabling of devices
   Date:   2005-11-11
   Origin: Peter Eriksson <peter at ifm.liu dot se>
   Status:

   What:  After a configurable amount of fatal errors with a tape drive
          Bacula should automatically disable further use of a certain
          tape drive. There should also be "disable"/"enable" commands in
          the "bconsole" tool.

   Why:   On a multi-drive jukebox there is a possibility of tape drives
          going bad during large backups (needing a cleaning tape run,
          tapes getting stuck). It would be advantageous if Bacula would
          automatically disable further use of a problematic tape drive
          after a configurable amount of errors has occurred.

          An example: I have a multi-drive jukebox (6 drives, 380+ slots)
          where tapes occasionally get stuck inside the drive. Bacula will
          notice that the "mtx-changer" command will fail and then fail
          any backup jobs trying to use that drive. However, it will still
          keep on trying to run new jobs using that drive and fail -
          forever, and thus failing lots and lots of jobs... Since we have
          many drives Bacula could have just automatically disabled
          further use of that drive and used one of the other ones
          instead.

Item 25:  Implement huge exclude list support using hashing.
  Date:   28 October 2005
  Origin: Kern
  Status: 

  What:   Allow users to specify very large exclude list (currently
          more than about 1000 files is too many).

  Why:    This would give the users the ability to exclude all
          files that are loaded with the OS (e.g. using rpms
          or debs). If the user can restore the base OS from
          CDs, there is no need to backup all those files. A
          complete restore would be to restore the base OS, then
          do a Bacula restore. By excluding the base OS files, the
          backup set will be *much* smaller.


============= Empty Feature Request form ===========
Item n:   One line summary ...
  Date:   Date submitted 
  Origin: Name and email of originator.
  Status: 

  What:   More detailed explanation ...

  Why:    Why it is important ...

  Notes:  Additional notes or features (omit if not used)
============== End Feature Request form ==============


===============================================
Feature requests submitted after cutoff for December 2005 vote
  and not yet discussed.
===============================================
Item n:   Allow skipping execution of Jobs
  Date:   29 November 2005
  Origin: Florian Schnabel <florian.schnabel at docufy dot de>
  Status:

     What: An easy option to skip a certain job  on a certain date.
     Why:  You could then easily skip tape backups on holidays.  Especially
           if you got no autochanger and can only fit one backup on a tape
           that would be really handy, other jobs could proceed normally
           and you won't get errors that way.

===================================================

Item n: archive data

  Origin: calvin streeting calvin at absentdream dot com
  Date:   15/5/2006

  What:   The abilty to archive to media (dvd/cd) in a uncompressd format
          for dead filing (archiving not backing up)

  Why:  At my works when jobs are finished and moved off of the main file
        servers (raid based systems) onto a simple linux file server (ide based
        system) so users can find old information without contacting the IT
        dept.

        So this data dosn't realy change it only gets added to,
        But it also needs backing up.  At the moment it takes
        about 8 hours to back up our servers (working data) so
        rather than add more time to existing backups i am trying
        to implement a system where we backup the acrhive data to
        cd/dvd these disks would only need to be appended to
        (burn only new/changed files to new disks for off site
        storage).  basialy understand the differnce between
        achive data and live data.

  Notes: scan the data and email me when it needs burning divide
          into predifind chunks keep a recored of what is on what
          disk make me a label (simple php->mysql=>pdf stuff) i
          could do this bit ability to save data uncompresed so
          it can be read in any other system (future proof data)
          save the catalog with the disk as some kind of menu
          system 

Item :  Tray monitor window cleanups
  Origin: Alan Brown ajb2 at mssl dot ucl dot ac dot uk
  Date:   24 July 2006
  Status:
  What:   Resizeable and scrollable windows in the tray monitor.

  Why:    With multiple clients, or with many jobs running, the displayed
          window often ends up larger than the available screen, making
          the trailing items difficult to read.

   Notes:

  Item :  Clustered file-daemons
  Origin: Alan Brown ajb2 at mssl dot ucl dot ac dot uk
  Date:   24 July 2006
  Status:
  What:   A "virtual" filedaemon, which is actually a cluster of real ones.

  Why:    In the case of clustered filesystems (SAN setups, GFS, or OCFS2, etc)
          multiple machines may have access to the same set of filesystems

          For performance reasons, one may wish to initate backups from
          several of these machines simultaneously, instead of just using
          one backup source for the common clustered filesystem.

          For obvious reasons, normally backups of $A-FD/$PATH and
          B-FD/$PATH are treated as different backup sets. In this case
          they are the same communal set.

          Likewise when restoring, it would be easier to just specify
          one of the cluster machines and let bacula decide which to use.

          This can be faked to some extent using DNS round robin entries
          and a virtual IP address, however it means "status client" will
          always give bogus answers. Additionally there is no way of
          spreading the load evenly among the servers.

          What is required is something similar to the storage daemon
          autochanger directives, so that Bacula can keep track of
          operating backups/restores and direct new jobs to a "free"
          client.

   Notes:

Item :  Tray monitor window cleanups
  Origin: Alan Brown ajb2 at mssl dot ucl dot ac dot uk
  Date:   24 July 2006
  Status:
  What:   Resizeable and scrollable windows in the tray monitor.

  Why:    With multiple clients, or with many jobs running, the displayed
          window often ends up larger than the available screen, making
          the trailing items difficult to read.

  Notes:

Item:    Commercial database support
  Origin: Russell Howe <russell_howe dot wreckage dot org>
  Date:   26 July 2006
  Status:

  What:   It would be nice for the database backend to support more 
          databases. I'm thinking of SQL Server at the moment, but I guess Oracle, 
          DB2, MaxDB, etc are all candidates. SQL Server would presumably be 
          implemented using FreeTDS or maybe an ODBC library?

  Why:    We only really have one database server, which is MS SQL Server 
          2000. Maintaining a second one for the backup software (we grew out of 
          SQLite, which I liked, but which didn't work so well with our database 
          size). We don't really have a machine with the resources to run 
          postgres, and would rather only maintain a single DBMS. We're stuck with 
          SQL Server because pretty much all the company's custom applications 
          (written by consultants) are locked into SQL Server 2000. I can imagine 
          this scenario is fairly common, and it would be nice to use the existing 
          properly specced database server for storing Bacula's catalog, rather 
          than having to run a second DBMS.


Item n:   Split documentation
  Origin: Maxx <maxxatworkat gmail dot com>
  Date:   27th July 2006
  Status:

  What:   Split documentation in several books

  Why:    Bacula manual has now more than 600 pages, and looking for
          implementation details is getting complicated.  I think
          it would be good to split the single volume in two or
          maybe three parts:

          1) Introduction, requirements and tutorial, typically
             are useful only until first installation time

          2) Basic installation and configuration, with all the
             gory details about the directives supported 3)
             Advanced Bacula: testing, troubleshooting, GUI and
             ancillary programs, security managements, scripting,
             etc.

  Notes:


</pre>

        </td>
</tr>
</table>

<? require_once("inc/footer.php"); ?>
