

#include "MyProject.h"
#include "Inventory.h"


AInventory::AInventory(const class FPostConstructInitializeProperties& PCIP)
	: Super(PCIP)
{
	nextSlot= 0;
	numItems= 0;
	currentSlot= 0;
	Inventory.Clear();
	Inventory.AddUninitialized(ItemType::I_Trash + 1, 0);
}

void AInventory::BeginPlay()
{
	GEngine->AddOnScreenDebugMessage(-1, 5.f, FColor::Red, TEXT("Inventory created"));
	nextSlot= 0;
	numItems= 0;
	currentSlot= 0;
}

void AInventory::LoadInventory()
{
	GEngine->AddOnScreenDebugMessage(-1, 5.f, FColor::Red, TEXT("Inventory Loaded"));
}

//adds specified item to the inventory
//increases the next open slot var as well as
//the record of number of items held
void AInventory::AddToInventory(ABaseItem* newItem)
{
	GEngine->AddOnScreenDebugMessage(-1, 2.f, FColor::Red, "Add Item Called");

	int32 slot= CheckForPartialStacks(newItem);


	if( slot >= 0)
	{
		if(Inventory.Tabs[newItem->Type].Items[slot]->CurrentStackSize < Inventory.Tabs[newItem->Type].Items[slot]->MaxStackSize)
		{
			
			//Inventory.Tabs[newItem->Type].Items[slot]= newItem;
			Inventory.Tabs[newItem->Type].Items[slot]->CurrentStackSize++;
			FString text= FString("Item added to slot: " + FString::FromInt(slot) + ". With a stack of: " + FString::FromInt(Inventory.Tabs[newItem->Type].Items[slot]->CurrentStackSize));
			GEngine->AddOnScreenDebugMessage(-1, 2.f, FColor::Red, text);
		}
		else
		{
			//some notification must be made to player that they can't carry anymore
			//currently displayed through debug text
			FString text= FString("You are currently carrying the max amount of " +FString(newItem->GetName()) +"s");
			GEngine->AddOnScreenDebugMessage(-1, 2.f, FColor::Red, text);
		}
	}
	else
	{
		int32 NextSlot= Inventory.Tabs[newItem->Type].Items.Num();
		Inventory.AddNewItemSlotInTab(newItem->Type);
		Inventory.Tabs[newItem->Type].Items[NextSlot]= newItem;
		++nextSlot;
		++numItems;
		FString text= FString("New slot created. Item added. # of items in inventory: " + FString::FromInt(numItems));
		GEngine->AddOnScreenDebugMessage(-1, 2.f, FColor::Red, text);
	}
}

//returns the item in the specified slot
ABaseItem* AInventory::GetItem(ItemType Type, int32 slotNum)
{
	return Inventory.Tabs[Type].Items[slotNum];
}

//returns the value of the item 
//as well as removing the item from inventory
int32 AInventory::SellItem(int32 slotNum)
{
	int32 value= Inventory.Tabs[0].Items[slotNum]->GetValue();
	//function currently assumes that it is qty of 1
	//per slot
	//will change upon specification
	RemoveItem(slotNum);
	return value;
}

//may not need this
//removeItem seems to cover all functions at the moment
void AInventory::DeleteItem(int32 slotNum)
{
	RemoveItem(slotNum);
	
}

//gets the next item in the inventory
//if currentSlot selected is greater than the number
//of item slots in inventory reset back to the beginning
ABaseItem* AInventory::NextItem()
{
	++currentSlot;
	if(currentSlot >= numItems)
	{
		currentSlot= 0;
	}
	return Inventory.Tabs[0].Items[currentSlot];
}

//gets the previous item in the inventory
//if currentSlot selected is less than 0
//loop to the slot of numItems -1
ABaseItem* AInventory::PreviousItem()
{
	--currentSlot;
	if(currentSlot < 0)
	{
		currentSlot= numItems - 1;
	}
	return Inventory.Tabs[0].Items[currentSlot];
}

//removes the item from inventory
//shifts down the items above it in the inventory
void AInventory::RemoveItem(int32 slotNum)
{
	Inventory.Tabs[0].Items[slotNum]= NULL;
	int32 TabSize= Inventory.Tabs[0].Items.Num();
	for(int32 i= slotNum+1; i<TabSize; ++i)
	{
		Inventory.Tabs[0].Items[i-1]= Inventory.Tabs[0].Items[i];
	}
	Inventory.Tabs[0].Items[TabSize - 1]->Destroy();
	--numItems;
	--nextSlot;
}

//checks if a slot in inventory is already occupied by the item that has been picked up
int32 AInventory::CheckForPartialStacks(ABaseItem* item)
{
	int32 TabSize= Inventory.Tabs[item->Type].Items.Num();
	for(int32 i= 0; i < TabSize; ++i)
	{
		//will change to int ID or what is decided upon for a significant itemID
		if(item->GetName().Equals(Inventory.Tabs[item->Type].Items[i]->GetName()))
		{
			//if items match, return slot number
			return i;
		}
	}
	//if no match is found return an invalid slot, to signify a new slot must be used
	return -1;
}


