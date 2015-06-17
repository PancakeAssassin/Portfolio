

#pragma once

#include "GameFramework/Actor.h"
#include "BaseItem.h"
#include "Inventory.generated.h"

/**
 * 
 */

USTRUCT()
struct FInventoryTab
{
	GENERATED_USTRUCT_BODY()

	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= "Inventory")
	TArray<ABaseItem*> Items;

	FInventoryTab()
	{

	}

	void AddNewItem()
	{
		Items.Add(NULL);
	}
};

USTRUCT()
struct FInv
{
	GENERATED_USTRUCT_BODY()

	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= "Inventory")
	TArray<FInventoryTab> Tabs;

	void AddNewTab()
	{
		Tabs.Add(FInventoryTab());
	}

	void AddUninitialized(const int32 NumTypes, const int32 ItemsPerTab)
	{
		//add tabs
		for(int i= 0; i < NumTypes; ++i)
		{
			AddNewTab();
		}

		//add items to tabs
		for(int32 i = 0; i < NumTypes; ++i)
		{
			for(int32 i= 0; i < ItemsPerTab; ++i)
			{
				Tabs[i].AddNewItem();
			}
		}
	}

	void AddNewItemSlotInTab(const int32 TabNum)
	{
		Tabs[TabNum].AddNewItem();
	}

	void Clear()
	{
		if(Tabs.Num() <= 0) return;

		const int32 NumTabs= Tabs.Num();
		int32 ItemsPerTab=  Tabs[0].Items.Num();

		for(int32 i=0; i < NumTabs; ++i)
		{
			int32 ItemsPerTab=  Tabs[i].Items.Num();
			for(int32 j= 0; j < ItemsPerTab; ++j)
			{
				if(Tabs[i].Items[j] &&  Tabs[i].Items[j]->IsValidLowLevel())
				{
					Tabs[i].Items[j]->Destroy();
				}
			}
		}

		for(int32 i= 0; i < Tabs.Num(); ++i)
		{
			Tabs[i].Items.Empty();
		}
		Tabs.Empty();
	}

	FInv()
	{
	}
};


UCLASS()
class MYPROJECT_API AInventory : public AActor
{
	GENERATED_UCLASS_BODY()

	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category= "Inventory")
	FInv Inventory;

	//adds an item to the inventory
	UFUNCTION(BlueprintCallable, Category= "Inventory")
	void AddToInventory(ABaseItem* newItem);

	//returns a pointer to the selected item
	UFUNCTION(BlueprintCallable, BlueprintPure, Category= "Inventory")
	ABaseItem* GetItem(ItemType Type, int32 slotNum);

	UFUNCTION(BlueprintCallable, BlueprintPure, Category= "Inventory")
	ABaseItem* NextItem();

	UFUNCTION(BlueprintCallable, BluePrintPure, Category= "Inventory")
	ABaseItem* PreviousItem();

	//sells the item, returns the value of the item
	//uses remove item
	UFUNCTION(BlueprintCallable, Category= "Inventory")
	int32 SellItem(int32 slotNum);

	//deletes the item from inventory
	//uses remove item 
	UFUNCTION(BlueprintCallable, Category= "Inventory")
	void DeleteItem(int32 slotNum);

	UFUNCTION(BlueprintCallable, Category= "Inventory")
	void LoadInventory();

	virtual void BeginPlay() override;

	int32 CheckForPartialStacks(ABaseItem* item);

private:
	//removes an item from the inventory
	//used in both DeleteItem and SellItem  
	void RemoveItem(int32 slotNum);

	//the next slot to place an item in
	int32 nextSlot;

	//the number of unique slots items are held in
	int32 numItems;

	//current selected slot
	int32 currentSlot;
};
