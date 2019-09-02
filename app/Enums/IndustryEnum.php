<?php

namespace App\Enums;

use Spatie\Enum\Enum;

class IndustryEnum extends Enum
{
    public static function agriculture(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Agriculture';
            }
        };
    }

    public static function education(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Education';
            }
        };
    }

    public static function information_communication_technologies(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Information & Communication Technologies';
            }
        };
    }

    public static function health(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Health';
            }
        };
    }

    public static function financial_services(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Financial services';
            }
        };
    }

    public static function technical_assistance_services(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Technical Assistance Services';
            }
        };
    }

    public static function environment(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Environment';
            }
        };
    }

    public static function artisanal(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Artisanal';
            }
        };
    }

    public static function energy(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Energy';
            }
        };
    }

    public static function culture(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Culture';
            }
        };
    }

    public static function tourism(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Tourism';
            }
        };
    }

    public static function supply_chain_services(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Supply Chain services';
            }
        };
    }

    public static function housing_development(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Housing Development';
            }
        };
    }

    public static function infrastructure_facilities_development(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Infrastructure & Facilities Development';
            }
        };
    }

    public static function water(): IndustryEnum
    {
        return new class() extends IndustryEnum {
            public function getValue(): string
            {
                return 'Water';
            }
        };
    }
}
