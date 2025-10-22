-- Fix payments table structure
-- Add missing columns if they don't exist

-- Add phone_number column if it doesn't exist
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name = 'payments' AND column_name = 'phone_number') THEN
        ALTER TABLE payments ADD COLUMN phone_number VARCHAR(255);
    END IF;
END $$;

-- Add contribution_id column if it doesn't exist
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name = 'payments' AND column_name = 'contribution_id') THEN
        ALTER TABLE payments ADD COLUMN contribution_id INTEGER DEFAULT 1;
    END IF;
END $$;

-- Add payment_reference column if it doesn't exist
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name = 'payments' AND column_name = 'payment_reference') THEN
        ALTER TABLE payments ADD COLUMN payment_reference VARCHAR(255);
    END IF;
END $$;

-- Add gateway_response column if it doesn't exist
DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name = 'payments' AND column_name = 'gateway_response') THEN
        ALTER TABLE payments ADD COLUMN gateway_response TEXT;
    END IF;
END $$;

-- Show current table structure
\d payments;
