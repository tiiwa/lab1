<?php

namespace App\Enums;

use Spatie\Enum\Enum;

class ImpactAreaEnum extends Enum
{
    public static function access_to_clean_water(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Access To Clean Water';
            }
        };
    }

    public static function access_to_education(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Access To Education';
            }
        };
    }

    public static function access_to_energy(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Access To Energy';
            }
        };
    }

    public static function access_to_financial_services(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Access To Financial Services';
            }
        };
    }

    public static function affordable_housing(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Affordable Housing';
            }
        };
    }

    public static function agriculture_productivity(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Agriculture Productivity';
            }
        };
    }

    public static function capacity_building(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Capacity Building';
            }
        };
    }

    public static function community_development(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Community Development';
            }
        };
    }

    public static function employment_generation(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Employment Generation';
            }
        };
    }

    public static function equality_and_empowerment(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Equality And Empowerment';
            }
        };
    }

    public static function food_security(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Food Security';
            }
        };
    }

    public static function generate_funds_for_charitable_giving(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Generate Funds For Charitable Giving';
            }
        };
    }

    public static function health_improvement(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Health Improvement';
            }
        };
    }

    public static function income_productivity_growth(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Income & Productivity Growth';
            }
        };
    }

    public static function access_to_information(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Access To Information';
            }
        };
    }

    public static function natural_resources_biodiversity(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Natural Resources & Biodiversity';
            }
        };
    }

    public static function pollution_prevention_and_waste_management(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Pollution Prevention And Waste Management';
            }
        };
    }

    public static function sustainable_energy_fuel_efficiency(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Sustainable Energy & Fuel Efficiency';
            }
        };
    }

    public static function sustainable_land_use(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Sustainable Land Use';
            }
        };
    }

    public static function support_for_high_impact_entrepreneurs(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Support For High-impact Entrepreneurs';
            }
        };
    }

    public static function support_for_women_and_girls(): ImpactAreaEnum
    {
        return new class() extends ImpactAreaEnum {
            public function getValue(): string
            {
                return 'Support For Women And Girls';
            }
        };
    }
}
