<?php

return [
    'backup' => [
        'name' => env('APP_NAME', 'laravel-backup'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],
                'follow_links' => false,
                'ignore_unreadable_directories' => false,
                'relative_path' => null,
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'compression_method' => ZipArchive::CM_DEFAULT,
            'compression_level' => 9,
            'filename_prefix' => '',
            'disks' => [
                'backups', // Use the custom disk for backups
            ],
        ],
        'temporary_directory' => storage_path('app/backup-temp'),
        'password' => env('BACKUP_ARCHIVE_PASSWORD'),
        'encryption' => 'default',
        'tries' => 1,
        'retry_delay' => 0,
    ],

    'notifications' => [
        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class => ['mail'],
        ],
        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,
        'mail' => [
            'to' => 'your@example.com',
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],
    ],

    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'laravel-backup'),
            'disks' => ['backups'], // Monitor backups on the custom disk
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,
        'default_strategy' => [
            'keep_all_backups_for_days' => 7,
            'keep_daily_backups_for_days' => 16,
            'keep_weekly_backups_for_weeks' => 8,
            'keep_monthly_backups_for_months' => 4,
            'keep_yearly_backups_for_years' => 2,
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
        'tries' => 1,
        'retry_delay' => 0,
    ],
];
